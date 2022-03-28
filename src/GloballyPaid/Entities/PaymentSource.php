<?php 
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

/**
 * PaymentSource
 * 
 * Use a payment source as a "source" for a transaction.
 * @see \GloballyPaid\Entities\CardOnFileSource
 * @see \GloballyPaid\Entities\CreditCardSource 
 */
class PaymentSource
{
    /**
     * The payment source type (card_on_file|credit_card)
     * @var string
     */
    public $type;
    
    /**
     * Billing contact for the payment source (optional for card_on_file)
     * @var ContactDetails
     */
    public $billing_contact = null;
    
    /**
     * Shipping details for the payment source (optional)
     * @var ContactDetails
     */
    public $shipping_contact = null;

}
