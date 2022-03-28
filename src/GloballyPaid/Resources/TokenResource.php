<?php
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Resources;

use GloballyPaid\Entities\Requests\Token;
use GloballyPaid\Entities\PaymentInstrument;
use GloballyPaid\Entities\ApiResponse;

/**
 * Tokens Resource
 */
class TokenResource extends Resource
{
    protected $basePath = '/api/v1/vault/token';
    private $authHeader = [];
    public function __construct($config)
    {
        parent::__construct($config);
        $this->authHeader['authorization'] = 'Bearer ' . $this->publishableApiKey;
    }
    
    /**
     * Create a token from a payment instrument (i.e. credit card) to use
     * as a payment source in a charge request.
     * @param PaymentInstrument $paymentInstrument
     * @return ApiResponse
     * @api
     */
    public function create($paymentInstrument)
    {
        $request = new Token($paymentInstrument);
        return $this->request('POST', '', [], $request, $this->authHeader);
    }
    
    /**
     * Verify a One-Time-Password sent to the customer's phone
     * @param string $id The token or payment instrument ID
     * @param string $otp The One Time Password
     * @return ApiResponse
     * @api
     */
    public function verify_otp($id, $otp)
    {
        $request = ['source' => $id, 'otp' => $otp];
        return $this->request('POST', 'otp/verify', [], $request, $this->authHeader);
    }
    
    /**
     * Get the source for a token id
     * @param string $id The token ID
     * @return ApiResponse
     * @api
     */
    public function source($id)
    {
        return $this->request('POST', 'source', [], ['source' => $id]);
    }
    
    /**
     * Get the transaction token
     * @param string $id The token ID
     * @return ApiResponse
     * @api
     */
    public function transaction_token($id)
    {
        return $this->request('POST', 'transactiontoken', [], ['source' => $id]);
    }
    
}

