<?php
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

/**
 * PaymentInstrumentCreditCard
 * 
 * Use this object to create tokens and/or store credit cards in the Globally Paid vault
 */
class PaymentInstrumentCreditCard extends PaymentInstrument
{
    public $type = 'credit_card';
    /**
     * 
     * @var CreditCard
     */
    public $credit_card;
}

