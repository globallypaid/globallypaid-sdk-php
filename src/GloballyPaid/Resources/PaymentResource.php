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

use GloballyPaid\Entities\Requests\Charge;
use GloballyPaid\Entities\PaymentSource;
use GloballyPaid\Entities\TransactionDetails;
use GloballyPaid\Entities\MetaDetails;
use GloballyPaid\Entities\Requests\Capture;
use GloballyPaid\Entities\Requests\Refund;
use GloballyPaid\Entities\ApiResponse;

/**
 * Payments Resources
 */
class PaymentResource extends Resource
{
    protected $basePath = '/api/v1/payments';
    /**
     * summary
     */
    public function __construct($config)
    {
        parent::__construct($config);
    }
    
    /**
     *
     * @param PaymentSource $paymentSource
     * @param TransactionDetails $transactionDetails
     * @param MetaDetails $metaDetails
     * @return ApiResponse
     */
    public function charge($paymentSource, $transactionDetails, $metaDetails)
    {
        $request = new Charge($paymentSource, $transactionDetails, $metaDetails);
        return $this->request('POST', 'charge', [], $request);
    }
    
    /**
     * 
     * @param PaymentSource $paymentSource
     * @param TransactionDetails $transactionDetails
     * @param MetaDetails $metaDetails
     * @return ApiResponse
     */
    public function auth($paymentSource, $transactionDetails, $metaDetails) 
    {
        $transactionDetails->capture = false; // just to make sure...
        return $this->charge($paymentSource, $transactionDetails, $metaDetails);
    }
    
    /**
     * 
     * @param string $id Transaction ID from a previous auth request or charge request that wasn't captured
     * @param int $amount Amount. 999 = $9.99
     * @return ApiResponse
     */
    public function capture($id, $amount)
    {
        $request = new Capture($id, $amount);
        return $this->request('POST', 'capture', [], $request);
    }
    
    /**
     * 
     * @param string $id
     * @param int $amount
     * @param string $reason
     * @return ApiResponse
     */
    public function refund($id, $amount, $reason = '')
    {
        $request = new Refund($id, $amount, $reason);
        return $this->request('POST', 'refund', [], $request);
    }
    
    /**
     * 
     * @param string $id
     * @param int $amount
     * @param string $reason
     * @return ApiResponse
     */
    public function void($id, $amount, $reason = '')
    {
        return $this->refund($id, $amount, $reason);
    }
}