<?php
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

class CreditCard
{
    /**
     * Account number
     * @var string
     */
    public $account_number;
    
    /**
     * 4-digit expiration (e.g. 0425)
     * @var string
     */
    public $expiration;
    
    /**
     * CVV
     * @var string
     */
    public $cvv;
    
    /**
     * Card brand
     * @var string
     */
    public $brand;
    
    /**
     * Last 4 digits of card
     * @var string
     */
    public $last_four;
    
    public function __construct($account_number = null, $expiration = null, $cvv = null)
    {
        $this->account_number = $account_number;
        $this->expiration = $expiration;
        $this->cvv = $cvv;
    }
}

