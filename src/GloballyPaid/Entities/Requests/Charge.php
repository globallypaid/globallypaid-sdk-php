<?php
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities\Requests;

use GloballyPaid\Entities\TransactionDetails;
use GloballyPaid\Entities\MetaDetails;
use GloballyPaid\Entities\PaymentSource;

/**
 * The charge request object
 */
class Charge
{

    /**
     * The source of payment for a transaction. Either CardOnFileSource or CreditCardSource
     * @var PaymentSource
     */
    public $source;
    /**
     * Transaction details
     * @var TransactionDetails
     */
    public $transaction;
    /**
     * Meta details for the transaction
     * @var MetaDetails
     */
    public $meta;
    
    /**
     * Constructor
     * @param PaymentSource $source The source of payment (CardOnFileSource|CreditCardSource)
     * @param TransactionDetails $transactionDetails Transaction details.
     * @param MetaDetails $metaDetails Meta details. 
     */
    public function __construct($source, $transactionDetails, $metaDetails)
    {
        $this->source = $source;
        $this->transaction = $transactionDetails;
        $this->meta = $metaDetails;
    }
}