<?php
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

/**
 * Address
 */
class Address
{
    /**
     * Address line 1
     * @var string
     */
    public $line_1;
    /**
     * Address line 2
     * @var string
     */
    public $line_2;
    /**
     * Address city
     * @var string
     */
    public $city;
    /**
     * Address state
     * @var string
     */
    public $state;
    /**
     * Address postal code.
     * This is generally a required field when charging a credit card
     * @var string
     */
    public $postal_code;
    /**
     * Address country code.
     * Must be an ISO 3166 3-letter country code
     * @var string
     */
    public $country_code;
}