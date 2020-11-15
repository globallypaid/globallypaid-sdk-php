<?php

class Customers extends GloballyPaid
{

    public function __construct()
    {
        $this->GloballyPaid = parent::$mainInstance;
    }

    /**
     * Customer create request
     * 
     * @param array $data Customer data
     * 
     * @return object Response as PHP object
     */
    public function create($data = [])
    {
        $this->GloballyPaid->setTransactionsBaseUrl('post');
        $customerCallResponse = $this->GloballyPaid->customer($data);
        return $customerCallResponse;
    }

    /**
     * Customer update request
     * 
     * @param string $id Customer id
     * @param array $data Customer data
     * 
     * @return object Response as PHP object
     */
    public function update($id, $data = [])
    {
        $initialData = (array) $this->get($id);
        $dataForRequest = array_merge($initialData, $data);
        $this->GloballyPaid->setTransactionsBaseUrl('put');
        $customerCallResponse = $this->GloballyPaid->customer($id, $dataForRequest);
        return $customerCallResponse;
    }

    /**
     * Customer get all request
     * 
     * @param string $params query strings if available
     * 
     * @return object Response as PHP object
     */
    public function all($params = null)
    {
        $this->GloballyPaid->setTransactionsBaseUrl('get');
        $customerCallResponse = $this->GloballyPaid->customer($params);
        return $customerCallResponse;
    }

    /**
     * Customer get by id
     * 
     * @param string $id Customer id
     * 
     * @return object Response as PHP object
     */
    public function retrieve($id)
    {
        if (is_array($id)) {
            return false;
        }
        $this->GloballyPaid->setTransactionsBaseUrl('get');
        $customerCallResponse = $this->GloballyPaid->customer($id);
        return $customerCallResponse;
    }

    /**
     * Alias from retrieve
     */
    public function get($id)
    {
        return $this->retrieve($id);
    }

    /**
     * Customer delete by id
     * 
     * @param string $id Customer id
     * 
     * @return object Response as PHP object
     */
    public function delete($id)
    {
        if (is_array($id)) {
            return false;
        }
        $this->GloballyPaid->setTransactionsBaseUrl('delete');
        $customerCallResponse = $this->GloballyPaid->customer($id);
        return $customerCallResponse;
    }
}
