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
        $this->GloballyPaid->setTokenBaseUrl('post');
        $piCallResponse = $this->GloballyPaid->paymentInstrument($data);
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
        $this->GloballyPaid->setTokenBaseUrl('put');
        $piCallResponse = $this->GloballyPaid->paymentInstrument($id, $dataForRequest);
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
        $this->GloballyPaid->setTokenBaseUrl('get');
        $piCallResponse = $this->GloballyPaid->paymentInstrument_list($params, $query);
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
        $this->GloballyPaid->setTokenBaseUrl('get');
        $piCallResponse = $this->GloballyPaid->paymentInstrument($id, $query);
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
        $this->GloballyPaid->setTokenBaseUrl('delete');
        $piCallResponse = $this->GloballyPaid->paymentInstrument($id);
        return $piCallResponse;
    }
}
