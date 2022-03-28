<?php 
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Resources;
use \GuzzleHttp\Client;
use GloballyPaid\Entities\ApiResponse;

/**
 * Resource base class
 */
class Resource
{

    /**
     * The publishable API key
     * @var string
     */
    protected $publishableApiKey;

    /**
     * The shared secret.
     * @var string
     */
    protected $sharedSecret;

    /**
     * The application ID
     * @var string
     */
    protected $appId;

    /**
     * Determines which host to call
     * @var boolean
     */
    protected $useSandbox;
    
    /**
     * Return associative arrays instead of \stdClass objects from the API
     * @var boolean
     */
    protected $returnArrays = false;
    
    /**
     * Request timeout in seconds
     * @var integer
     */
    protected $timeout = 30;

    /**
     * The hostname
     * @var string
     */
    protected $hostName;

    /**
     * The base path to the API.
     * Override this property in child classes to set an effective "base" path to use.
     * @var string
     */
    protected $basePath = '/api/v1';

    /**
     * @var \GuzzleHttp\Client
     */
    protected static $client = null;
    
    protected function __construct($config)
    {
        $this->publishableApiKey = isset($config['PublishableApiKey']) ? $config['PublishableApiKey'] : '';
        $this->sharedSecret = isset($config['SharedSecret']) ? $config['SharedSecret'] : '';
        $this->appId = isset($config['AppId']) ? $config['AppId'] : '';
        $this->useSandbox = isset($config['Sandbox']) && $config['Sandbox'] === true;
        $this->hostName = ($this->useSandbox ? 'sandbox.' : '') . 'api.globallypaid.com';
        $this->timeout = (isset($config['RequestTimeout']) && is_numeric($config['RequestTimeout'])) ? 
            $config['RequestTimeout'] : $this->timeout;
        $this->returnArrays = (isset($config['ReturnArrays']) && is_bool($config['ReturnArrays'])) ?
            $config['ReturnArrays'] : $this->returnArrays;
        $base_uri = "https://{$this->hostName}";
        
        if (static::$client == null) {
            echo "New client" . PHP_EOL;
            static::$client = new Client([
                'base_uri' => $base_uri,
                'timeout' => $this->timeout,
                'http_errors' => false,
                'headers' => [
                    'content-type' => 'application/json',
                    'accept' => 'application/json',
                    'user-agent' => sprintf('globallypaid-php-sdk/2.0;cURL/%s;php/%s', curl_version()['version'], PHP_VERSION),
                    'authorization' => sprintf('Basic %s', base64_encode("{$this->appId}:{$this->sharedSecret}"))
                    
                ]
            ]);
        }
        
        if (strlen($this->basePath) > 0 && substr($this->basePath, -1) == '/') {
            $this->basePath = substr($this->basePath, 0, -1);
        }
    }
    
    /**
     * One request to rule them all.
     * This is called from child classes to make requests to the API
     * @param string $method HTTP method (GET|POST|PUT|DELETE)
     * @param string $resource The resource being requested
     * @param array $query
     * @param object $data Data to post/put to the API
     * @param array $headers
     * @return \GloballyPaid\Entities\ApiResponse
     */
    protected function request($method, $resource, $query = [], $data = null, $headers = [])
    {
        $path = $this->basePath;
        if (strlen($resource) > 0) {
            // if $resource starts with /, treat it as an absolute path
            if (substr($resource, 0, 1) == '/') {
                $path = $resource;
            } else {
                // append it to $this->basePath
                $path .= "/{$resource}";
            }
        }
        
        $request = [
            'query' => $query,
            'headers' => $headers
        ];
        if (strtoupper($method) != 'GET' && $data != null) {
            $request['body'] = json_encode($data);
        }
        $apiResponse = new ApiResponse();
        try {
            $response = static::$client->request($method, $path, $request);
            $apiResponse->status = $response->getStatusCode();
            $apiResponse->message = $response->getReasonPhrase();
            $body = (string)$response->getBody();
            if (strlen($body) > 0) {
                $payload = json_decode($body, $this->returnArrays);
                if (json_last_error() == JSON_ERROR_NONE) {
                    $apiResponse->payload = $payload;
                } else {
                    $apiResponse->status = 1000 + json_last_error();
                    $apiResponse->message = 'Error parsing response from API';
                }
            } else {
                $apiResponse->payload = null;
            }
        } catch (\Exception $e) {
            $apiResponse->status = -1;
            $apiResponse->message = "Unknown Error: {$e->getMessage()}";
        }
        return $apiResponse;
        
    }
    
}
