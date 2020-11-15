<?php

class Charges extends GloballyPaid
{

    public function __construct()
    {
        $this->GloballyPaid = parent::$mainInstance;
        $this->defaultData = [
            'source' => null,
            'amount' => null,
            'capture' => true,
            'client_customer_id' => '000000',
            'recurring' => false,
            'avs' => false,
            'currency_code' => null,
            'client_transaction_id' => '000000',
            'client_transaction_description' => 'No description',
            'client_invoice_id' => '000000',
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
            'browser_header' => null,
            'save_payment_instrument' => false
        ];
    }

    /**
     * Creating charge request
     * 
     * @param array $data Data for request
     * 
     * @return object Response as PHP object
     */
    public function create($data = [])
    {
        if (isset($data['currency'])) {
            $data['currency_code'] = $data['currency'];
            unset($data['currency']);
        }
        if (isset($data['metadata'])) {
            $data = array_merge($data, $data['metadata']);
            unset($data['metadata']);
        }
        $requestData = array_merge($this->defaultData, $data);
        $this->GloballyPaid->setTransactionsBaseUrl('post');
        $chargeCallResponse = $this->GloballyPaid->charge($requestData);
        return $chargeCallResponse;
    }

    /**
     * Creating capture request
     * 
     * @param string $chargeId Charge id from charge response
     * @param integer $amount Amount including cents
     * 
     * @return object Response as PHP object
     */
    public function capture($chargeId, $amount = null)
    {
        $this->GloballyPaid->setTransactionsBaseUrl('post');
        return $this->GloballyPaid->capture(['charge' => $chargeId, 'amount' => $amount]);
    }

    /**
     * Creating refund request
     * 
     * @param string $chargeId Charge id from charge response
     * @param integer $amount Amount including cents
     * 
     * @return object Response as PHP object
     */
    public function refund($chargeId, $amount = null)
    {
        $this->GloballyPaid->setTransactionsBaseUrl('post');
        return $this->GloballyPaid->refund(['charge' => $chargeId, 'amount' => $amount]);
    }
}
