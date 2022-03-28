<?php
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities\Requests;

use GloballyPaid\Entities\Address;

/**
 * Customer request object
 */
class Customer
{
    /**
     * The identifier for the customer in your system
     * @var string
     */
    public $client_customer_id;
    /**
     * 
     * @var string
     */
    public $first_name;
    /**
     * 
     * @var string
     */
    public $last_name;
    /**
     * 
     * @var Address
     */
    public $address;
    /**
     * 
     * @var string
     */
    public $phone;
    /**
     * 
     * @var string
     */
    public $email;
}

