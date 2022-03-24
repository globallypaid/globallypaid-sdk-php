<?php
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
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

