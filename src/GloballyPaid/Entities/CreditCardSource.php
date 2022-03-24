<?php
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

/**
 * CreditCardSource
 * 
 * Use this to create a charge with a raw credit card.
 */
class CreditCardSource extends PaymentSource  implements \JsonSerializable
{
    public $type = 'credit_card';
    /**
     * CreditCard
     * @var CreditCard
     */
    public $credit_card;
    
    /**
     * 
     * {@inheritDoc}
     * @see \JsonSerializable::jsonSerialize()
     * @internal
     */
    public function jsonSerialize()
    {
        $obj = [
            'type' => $this->type,
            'credit_card' => $this->credit_card,
            'billing_contact' => $this->billing_contact
        ];
        if ($this->shipping_contact != null && $this->shipping_contact instanceof ContactDetails) {
            $obj['shipping_contact'] = $this->shipping_contact;
        }
        return $obj;
    }
}
