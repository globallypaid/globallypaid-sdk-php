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
     */
    public function source($id)
    {
        return $this->request('POST', 'source', [], ['source' => $id]);
    }
    
    /**
     * Get the transaction token
     * @param string $id The token ID
     * @return ApiResponse
     */
    public function transaction_token($id)
    {
        return $this->request('POST', 'transactiontoken', [], ['source' => $id]);
    }
    
}

