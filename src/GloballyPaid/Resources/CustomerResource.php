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

