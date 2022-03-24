<?php
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

/**
 * The API response object
 */
class ApiResponse
{
    /**
     * The HTTP status code from the API
     * @var int
     */
    public $status;
    /**
     * Any messages returned from the API, or the equivilent HTTP status description if none
     * @var string
     */
    public $message;
    /**
     * This is the actual payload returned from the GloballyPaid API. Please refer to 
     * the Postman collection you should have received as part of your onboarding package.
     * If you did not receive one, please reach out to engineering@gpgway.com. This will
     * either be a \stdClass (default) or associative array depending on your config
     * @var \stdClass|array
     */
    public $payload;
    
}

