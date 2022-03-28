<?php
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

/**
 * PaymentInstrument object
 * 
 * A payment instrument is what Globally Paid stores in its vault. Currently, the
 * only support PaymentInstrument is the PaymentInstrumentCreditCard 
 * @see \GloballyPaid\Entities\PaymentInstrumentCreditCard
 */
class PaymentInstrument
{
    /**
     * 
     * @var string
     */
    public $type;
    
    /**
     * 
     * @var ContactDetails
     */
    public $billing_contact;
    
}

