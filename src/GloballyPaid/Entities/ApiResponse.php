<?php
namespace GloballyPaid\Entities;

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
     * If you did not receive one, please reach out to engineering@gpgway.com
     * @var \stdClass
     */
    public $payload;
    /**
     * If an error occurs, this will be populated with a more detailed error message
     * @var string
     */
    public $error = null;
    /**
     * If an error occurs, a unique id for this particular request
     * @var string
     */
    public $trace_id = null;
}

