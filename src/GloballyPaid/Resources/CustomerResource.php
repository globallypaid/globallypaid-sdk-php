<?php
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Resources;

use GloballyPaid\Entities\Requests\Customer;
use GloballyPaid\Entities\ApiResponse;

class CustomerResource extends Resource
{
    protected $basePath = '/api/v1/vault/customer';
    
    protected function __construct($config)
    {
        parent::__construct($config);
    }
    
    
    /**
     * Create a customer in our vault
     * @param Customer $customer
     * @return ApiResponse
     */
    public function create($customer)
    {
        return $this->request('POST', '', [], $customer);
    }
    
    /**
     * Update a customer
     * @param string $id The id of the customer returned in a create() call
     * @param Customer $customer
     * @return ApiResponse
     */
    public function update($id, $customer)
    {
        return $this->request('PUT', $id, [], $customer);
    }
    
    public function delete($id)
    {
        return $this->request('DELETE', $id);
    }
}

