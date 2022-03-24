<?php 
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

/**
 * Meta Details
 * 
 * Use this on a transaction to assign various values to transactions 
 * for reporting purposes. Should keep the bean counters happy
 */
class MetaDetails
{
    /**
     * An id that signifies a customer in your system
     * @var string
     */
    public $client_customer_id;
    
    /**
     * A unique identifier to identify this transaction in your system
     * @var string
     */
    public $client_transaction_id;
    
    /**
     * A brief description for this transaction
     * @var string
     */
    public $client_transaction_description;
    
    /**
     * An invoice number/value for this transaction
     * @var string
     */
    public $client_invoice_id;
}