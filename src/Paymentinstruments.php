<?php

class Paymentinstruments extends GloballyPaid
{

    public function __construct()
    {
        $this->GloballyPaid = parent::$mainInstance;
    }

    /**
     * Paymentinstrument create request
     * 
     * @param array $data Paymentinstrument data
     * 
     * @return object Response as PHP object
     */
    public function create($data = [])
    {
        $this->GloballyPaid->setTransactionsBaseUrl('post');
        $piCallResponse = $this->GloballyPaid->paymentinstrument($data);
        return $piCallResponse;
    }

    /**
     * Paymentinstrument update request
     * 
     * @param string $id Paymentinstrument id
     * @param array $data Paymentinstrument data
     * 
     * @return object Response as PHP object
     */
    public function update($id, $data = [])
    {
        $initialData = (array) $this->get($id);
        $dataForRequest = array_merge($initialData, $data);
        $this->GloballyPaid->setTransactionsBaseUrl('put');
        $piCallResponse = $this->GloballyPaid->paymentinstrument($id, $dataForRequest);
        return $piCallResponse;
    }

    /**
     * Paymentinstrument get all request
     * 
     * @param string $params Customer id
     * @param array $query query strings if available
     * 
     * @return object Response as PHP object
     */
    public function all($params = null, $query = null)
    {
        $this->GloballyPaid->setTransactionsBaseUrl('get');
        $piCallResponse = $this->GloballyPaid->paymentinstrumentList($params, $query);
        return $piCallResponse;
    }

    /**
     * Paymentinstrument get by id request
     * 
     * @param string $id Paymentinstrument id
     * @param array $query query strings if available
     * 
     * @return object Response as PHP object
     */
    public function retrieve($id, $query = null)
    {
        if (is_array($id)) {
            return false;
        }
        $this->GloballyPaid->setTransactionsBaseUrl('get');
        $piCallResponse = $this->GloballyPaid->paymentinstrument($id, $query);
        return $piCallResponse;
    }

    /**
     * Alias from retrieve
     */
    public function get($id, $query = null)
    {
        return $this->retrieve($id, $query);
    }

    /**
     * Paymentinstrument delete by id request
     * 
     * @param string $id Paymentinstrument id
     * 
     * @return object Response as PHP object
     */
    public function delete($id)
    {
        if (is_array($id)) {
            return false;
        }
        $this->GloballyPaid->setTransactionsBaseUrl('delete');
        $piCallResponse = $this->GloballyPaid->paymentinstrument($id);
        return $piCallResponse;
    }
}
