<?php

class Charges extends GloballyPaid
{

    public function __construct()
    {
        $this->GloballyPaid = parent::$mainInstance;
        $this->defaultData = [
            'source' => [],
            'transaction' => [],
            'meta' => []
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
        if (isset($data['transaction']['currency'])) {
            $data['transaction']['currency_code'] = $data['transaction']['currency'];
            unset($data['transaction']['currency']);
        }
        // if (isset($data['metadata'])) {
        //     $data = array_merge($data, $data['metadata']);
        //     unset($data['metadata']);
        // }
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
