<?php 
/**
 * Copyright © 2022 Global Payroll Gateway, Inc
 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the “Software”), to deal in the
 * Software without restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the
 * Software, and to permit persons to whom the Software is furnished to do so, subject
 * to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @license MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Resources;
use GuzzleHttp\Client;

/**
 * Resource base class
 */
class Resource
{

    /**
     * @var string
     */
    protected $publishableApiKey;

    /**
     * @var string
     */
    protected $sharedSecret;

    /**
     * @var string
     */
    protected $appId;

    /**
     * @var boolean
     */
    protected $useSandbox;

    /**
     * @var string
     */
    protected $hostName;

    /**
     * @var string
     */
    protected $basePath = '/api/v1';

    /**
     * @var Client
     */
    protected $client;
    
    protected function __construct($config)
    {
        $this->publishableApiKey = isset($config['PublishableApiKey']) ? $config['PublishableApiKey'] : '';
        $this->sharedSecret = isset($config['SharedSecret']) ? $config['SharedSecret'] : '';
        $this->appId = isset($config['AppId']) ? $config['AppId'] : '';
        $this->useSandbox = isset($config['Sandbox']) && $config['Sandbox'] === true;
        $this->hostName = ($this->useSandbox ? 'sandbox.' : '') . 'api.globallypaid.com';
        $base_uri = "https://{$this->hostName}";
        $base_uri .= (substr($this->basePath, 0, 1) == '/' ? '':'/');
        
        $this->client = new Client([
            'base_uri' => $base_uri . $this->basePath,
            'timeout' => 10,
            'http_errors' => false,
            'headers' => [
                'content-type' => 'application/json',
                'accept' => 'application/json',
                'user-agent' => sprintf('globallypaid-php-sdk/2.0;cURL/%s;php/%s', curl_version()['version'], PHP_VERSION),
                'authorization' => sprintf('Basic %s', base64_encode("{$this->appId}:{$this->sharedSecret}"))
                
            ]
        ]);
    }
    
    /**
     * 
     * @param string $method HTTP method (GET|POST|PUT|DELETE)
     * @param string $resource The resource being requested
     * @param array $query
     * @param object $data Data to post/put to the API
     * @param array $headers
     * @return \GloballyPaid\Entities\ApiResponse
     */
    protected function request($method, $resource, $query = [], $data = null, $headers = [])
    {
        $request = [
            'query' => $query,
            'headers' => $headers
        ];
        if (strtoupper($method) != 'GET' && $data != null) {
            $request['body'] = json_encode($data);
        }
        $apiResponse = new \GloballyPaid\Entities\ApiResponse();
        try {
            $response = $this->client->request($method, $resource, $request);
            $apiResponse->status = $response->getStatusCode();
            $apiResponse->message = $response->getReasonPhrase();
            $body = (string)$response->getBody();
            if (strlen($body) > 0) {
                $payload = @json_decode($body);
                if (json_last_error() != 0) {
                    $apiResponse->message = 'Error parsing JSON response from API';
                    $apiResponse->error = json_last_error_msg();
                    $apiResponse->payload = $body;
                } else {
                    // This is an error response from APIGW, not the app
                    if (isset($payload->error)) {
                        $apiResponse->error = $payload->error;
                        $apiResponse->message = $payload->title;
                        $apiResponse->trace_id = $payload->trace_id;
                    } elseif ($apiResponse->status != 200) {
                        $apiResponse->error = $payload->message;
                        $apiResponse->trace_id = $payload->id;
                    } else {
                        $apiResponse->payload = $payload;
                    }
                }
            } else {
                $apiResponse->payload = null;
            }
        } catch (\Exception $e) {
            $apiResponse->status = -1;
            $apiResponse->message = 'Unknown Error';
            $apiResponse->error = $e->getMessage();
        }
        return $apiResponse;
        
    }
    
}
