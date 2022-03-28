<?php 
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

class ContactDetails
{
    /**
     * Cardholder first name
     * @var string
     */
    public $first_name;
    /**
     * Cardholder last name
     * @var string
     */
    public $last_name;
    /**
     * Cardholder address
     * @var Address
     */
    public $address;
    /**
     * Cardholder phone. Must be a valid mobile number for OTP.
     * @var string
     */
    public $phone;
    /**
     * Cardholder email address
     * @var string
     */
    public $email;
}
