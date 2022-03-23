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

use GloballyPaid\Entities\ApiResponse;
use GloballyPaid\Entities\PaymentInstrument;
use GloballyPaid\Entities\PaymentInstrumentCreditCard;

class PaymentInstrumentResource extends Resource
{
    protected $basePath = '/api/v1/vault/payment-instrument';
    
    protected function __construct($config)
    {
        parent::__construct($config);
    }
    
    /**
     * Create a payment instrument for a customer
     * @param string $customer_id The customer id received from customer->create()
     * @param PaymentInstrument $paymentInstrument A payment instrument to tokenize. Currently, only PaymentInstrumentCreditCard is supported
     * @return ApiResponse
     */
    public function create($customer_id, $paymentInstrument)
    {
        return $this->request('POST', $customer_id, [], $paymentInstrument);
    }
    
    /**
     * List all payment instruments for a customer_id
     * @param string $customer_id
     * @return \GloballyPaid\Entities\ApiResponse
     */
    public function list($customer_id)
    {
        return $this->request('GET', 'list/'.$customer_id);
    }
    
    /**
     * Update a payment instrument
     * @param string $customer_id The customer id
     * @param string $payment_instrument_id The payment instrument id
     * @param PaymentInstrument $paymentInstrument The PaymentInstrument object to update (PaymentInstrumentCreditCard)
     * @return \GloballyPaid\Entities\ApiResponse
     */
    public function update($customer_id, $payment_instrument_id, $paymentInstrument)
    {
        return $this->request('PUT', "$customer_id/$payment_instrument_id", [], $paymentInstrument);
    }
    
    /**
     * Get a payment instrument
     * @param string $customer_id The customer id
     * @param string $payment_instrument_id the payment instrument id
     * @return \GloballyPaid\Entities\ApiResponse
     */
    public function get($customer_id, $payment_instrument_id)
    {
        return $this->request('GET', "$customer_id/$payment_instrument_id");
    }
    
    /**
     * Delete a payment instrument
     * @param string $customer_id The customer id
     * @param string $payment_instrument_id the payment instrument id
     * @return \GloballyPaid\Entities\ApiResponse
     */
    public function delete($customer_id, $payment_instrument_id)
    {
        return $this->request('DELETE', "$customer_id/$payment_instrument_id");
    }
    
    
}

