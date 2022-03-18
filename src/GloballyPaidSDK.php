<?php

/**
 * Class GloballyPaid
 * 
 * GloballyPaid SDK for PHP
 * 
 */
class GloballyPaid
{

    static $config = [];
    static $mainInstance = [];

    /**
     * Initialize class object
     * 
     * @param array $config
     * 
     * @return object|false Return instance of the class or false if missing config
     */
    function __construct($config = [])
    {
        self::$config = $config;
        $this->sandbox = isset($config['Sandbox']) && $config['Sandbox'] === TRUE;
        $this->BaseURL = $this->sandbox ? 'https://sandbox.api.globallypaid.com' : 'https://api.globallypaid.com';
        $this->BaseTokenUrl = $this->BaseURL;
        $this->env_sharedSecretAPIKey = isset($config['SharedSecret']) ? $config['SharedSecret'] : 'SharedSecret';
        $this->env_appIdKey = isset($config['AppId']) ? $config['AppId'] : 'AppId';
        $this->KountSessionId = isset($config['KountSessionId']) ? $config['KountSessionId'] : rand(10000, 999999999);
        $this->ApiKey = isset($config['PublishableApiKey']) ? $config['PublishableApiKey'] : 'PublishableApiKey';
        $this->version = isset($config['ApiVersion']) ? $config['ApiVersion'] : 'v1';
        $this->ContentType = 'application/json';
        $this->requestTimeoutSeconds = isset($config['RequestTimeout']) ? (int) $config['RequestTimeout'] : 30;
        $this->UseBaseUrl = 'payments';
        $this->RequestType = 'post';
        $this->token = null;
        $this->payment_instrument = [];
        $this->chargeData = [
            'capture' => true,
            'recurring' => false,
            'avs' => false,
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
            'browser_header' => null,
            'save_payment_instrument' => false
        ];
        $this->errorResponse = [];
        $this->debugData = [];
        $this->errorCodes = [
            '204' => 'No Content.',
            '401' => 'Unauthorized -- Your API key is wrong.',
            '403' => 'Forbidden -- The endpoint requested is hidden for administrators only.',
            '404' => 'Not Found -- The specified endpoint could not be found.',
            '405' => 'Method Not Allowed -- You tried to access a request with an invalid method.',
            '406' => 'Not Acceptable -- You requested a format that isn\'t json.',
            '410' => 'Gone -- The endpoint requested has been removed from our servers.',
            '429' => 'Too Many Requests -- Your application is making too many requests! Slow down!',
            '500' => 'Internal Server Error -- We had a problem with our server. Try again later.',
            '503' => 'Service Unavailable -- We\'re temporarily offline for maintenance. Please try again later'
        ];
        spl_autoload_register(function ($class_name) {
            require_once $class_name . '.php';
        });
        self::$mainInstance = $this;
        $this->token = new Token;
        $this->charges = new Charges;
        $this->customers = new Customers;
        $this->paymentinstruments = new Paymentinstruments;
        $this->charge = new Charges;
        $this->customer = new Customers;
        $this->paymentinstrument = new Paymentinstruments;
    }

    /**
     * Dynamic API method builder
     * 
     * @param string $methodName name of the method
     * @param array $arguments arguments for that method as array
     * 
     * @return object|false Return object from API call as response
     */
    function __call($methodName, $arguments)
    {

        $parts = $this->splitUpperCase($methodName);
        $requestType = $this->RequestType;

        $endPoint = strtolower(str_replace('_', '/', implode('-', $parts)));
        $bodyData = isset($arguments[0]) ? $arguments[0] : null;
        $queryString = '';
        $uriSegments = '';
        if (in_array($requestType, ['get', 'delete']) && is_array($bodyData)) {
            $queryString = '?' . http_build_query($bodyData);
        }
        if (in_array($requestType, ['put']) && !is_array($arguments[0]) && isset($arguments[1]) && is_array($arguments[1])) {
            $bodyData = $arguments[1];
            $uriSegments = '/' . (string) $arguments[0];
            //$queryString = '?' . http_build_query($bodyData);
        }
        if (in_array($requestType, ['get']) && !@is_array($arguments[0]) && isset($arguments[1]) && is_array($arguments[1])) {
            $uriSegments = '/' . (string) $arguments[0];
            $queryString = '?' . http_build_query($arguments[1]);
        }
        if (!is_array($bodyData) && !is_null($bodyData)) {
            $uriSegments = '/' . (string) $bodyData;
        }
        $response = $this->request($endPoint . $uriSegments . $queryString, $bodyData, strtoupper($requestType));
        if (isset($response['response_code']) && $response['response_code'] != '00') {
            $this->errorResponse = ['errors' => ['other' => [$response['message']]], 'title' => isset($this->errorCodes[$response['response_code']]) ? $this->errorCodes[$response['response_code']] : $response['message'], 'status' => (int) $response['response_code'], 'originalResponse' => json_encode($response)];
            return false;
        } else if (isset($response['errors'])) {
            $this->errorResponse = $response;
            return false;
        } else if (isset($response['approved']) && !$response['approved']) {
            $this->errorResponse = $response;
            return false;
        }
        return (object) $response;
    }

    /**
     * Set dynamic config
     * 
     * @return void
     */
    public function setConfig($config = [])
    {
        $this->sandbox = isset($config['Sandbox']) && $config['Sandbox'] ? true : false;
        $this->BaseURL = $this->sandbox ? 'https://sandbox.api.globallypaid.com' : 'https://api.globallypaid.com';
        $this->BaseTokenUrl = $this->BaseURL;
        $this->env_sharedSecretAPIKey = isset($config['SharedSecret']) ? $config['SharedSecret'] : 'SharedSecret';
        $this->env_appIdKey = isset($config['AppId']) ? $config['AppId'] : 'AppId';
        $this->ApiKey = isset($config['PublishableApiKey']) ? $config['PublishableApiKey'] : 'PublishableApiKey';
        $this->version = isset($config['ApiVersion']) ? $config['ApiVersion'] : 'v1';
        $this->requestTimeoutSeconds = isset($config['RequestTimeout']) ? (int) $config['RequestTimeout'] : 30;
    }

    /**
     * Switch client to Token Base URL
     * 
     * @return void
     */
    public function setTokenBaseUrl($requestType = 'post')
    {
        $this->RequestType = $requestType;
        $this->UseBaseUrl = 'vault';
    }

    /**
     * Switch client to Transactions Base URL
     * 
     * @return void
     */
    public function setTransactionsBaseUrl($requestType = 'post')
    {
        $this->RequestType = $requestType;
        $this->UseBaseUrl = 'payments';
    }

    /**
     * Fetch errors from API calls
     * 
     * @return array Return errors in array
     */
    public function errors()
    {
        return $this->errorResponse;
    }

    /**
     * Fetch error from API calls
     * 
     * @return array Return errors in array
     */
    public function error()
    {
        return $this->errorResponse;
    }

    /**
     * Print or get debug data
     * 
     * @param bool $print Set true to print
     * 
     * @return array|null Return array with calls request/response or print if $print is set to true
     */
    public function debug($print = false)
    {
        if ($print) {
            foreach ($this->debugData as $debugItem)
                echo '<pre style="text-align:left; background:black; border-radius:5px; color:white; padding:20px; white-space: pre-wrap">REQUEST ------>>>' . PHP_EOL . '--------------' . PHP_EOL . PHP_EOL . print_r($debugItem['request'], true) . PHP_EOL . '==================================================================================================' . PHP_EOL . PHP_EOL . 'RESPONSE <<<------' . PHP_EOL . '--------------' . PHP_EOL . PHP_EOL . print_r($debugItem['response'], true) . '</pre>';
        } else {
            return $this->debugData;
        }
    }

    /**
     * HTTP method for request to API service
     * 
     * @param string $endpoint Set endpoint string ex. token
     * @param array $data Data for request
     * @param null|string $requestMethod Request method ex. POST GET DELETE
     * 
     * @return array Original response converted from JSON to array
     */
    private function request($endpoint, $data = [], $requestMethod = 'POST')
    {
        $baseUrl = $this->BaseURL;
        $url = "{$baseUrl}/api/{$this->version}/{$this->UseBaseUrl}/{$endpoint}";
        $curl = curl_init();
        $headers = [
            "authorization: Basic {base64_encode($this->env_appIdKey . ':' . $this->env_sharedSecretAPIKey)}",
            "content-type: " . $this->ContentType,
            "accept: */*"
        ];

//         if ($this->UseBaseUrl != 'token') {
//             if (in_array($requestMethod, ['DELETE'])) {
//                 $data = "\"\"";
//                 $headers = [];
//                 $headers[] = 'hmac: ' . $this->generateHmac("");
//             } else {
//                 $headers[] = 'hmac: ' . $this->generateHmac($data);
//             }
//         }
//         if (in_array($requestMethod, ['GET'])) {
//             unset($headers[3]);
//         }

        $curlOptions = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => $this->requestTimeoutSeconds,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $requestMethod,
            CURLOPT_POSTFIELDS => is_array($data) ? json_encode($data) : $data,
            CURLOPT_HTTPHEADER => $headers
        ];

        curl_setopt_array($curl, $curlOptions);
        $originalResponse = curl_exec($curl);
        $responseArray = explode(PHP_EOL, $originalResponse);
        $err = curl_error($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $response = end($responseArray);
        $this->debugData[] = [
            'request' => [
                'time' => date('Y-m-d H:i:s'),
                'url' => $url,
                'method' => 'HTTP/' . $requestMethod . ' (' . $this->ContentType . ')',
                'headers' => $headers,
                'body' => $data
            ],
            'response' => json_decode($response, true) ? json_decode($response, true) : $responseArray
        ];

        curl_close($curl);

        if ($err) {
            return ['errors' => ['other' => [$responseArray[0]]], 'title' => $this->errorCodes[500], 'status' => 500, 'originalResponse' => $err];
        } else {
            $statusCode = trim(explode(' ', $responseArray[0])[1]);
            if ($response == 'true') {
                return true;
            }
            if ($statusCode == 200) {
                $resp = json_decode($response, true);
                if (is_array($resp) && !$resp) {
                    return $resp;
                }
            }
            return json_decode($response, true) ? json_decode($response, true) : ['errors' => ['other' => [$responseArray[0]]], 'title' => $this->errorCodes[$statusCode], 'status' => (int) $statusCode, 'originalResponse' => $originalResponse];
        }
    }

    /**
     * Generate HMAC for request header
     * 
     * @param array $data Body data for requests
     * 
     * @return string Return generated HMAC needed for header of transaction requests
     */
    public function generateHmac($data)
    {
        $guid = md5(uniqid());
        $hashInBase64 = base64_encode(hash_hmac('sha256', @json_encode($data) ? @json_encode($data) : "", base64_decode($this->env_sharedSecretAPIKey), true));
        return base64_encode($this->env_appIdKey . ':POST:' . $guid . ':' . $hashInBase64);
    }

    /**
     * Generate HMAC for request header
     * 
     * @param array $string split string per upercase
     * 
     * @return array Return with strings separated by uppercase
     */
    private function splitUpperCase($string)
    {
        return preg_split('/(?=[A-Z])/', $string);
    }
}
