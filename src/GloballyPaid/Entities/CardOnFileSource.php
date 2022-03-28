<?php
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

/**
 * CardOnFileSource
 * 
 * A type of payment source when creating charge transactions. Use this
 * if you have stored a payment instrument in the GloballyPaid vault.
 */
class CardOnFileSource extends PaymentSource  implements \JsonSerializable
{
    public $type = 'card_on_file';
    /**
     * CardOnFile
     * @var CardOnFile
     */
    public $card_on_file;

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
            'card_on_file' => $this->card_on_file
        ];
        if ($this->billing_contact != null && $this->billing_contact instanceof ContactDetails) {
            $obj['billing_contact'] = $this->billing_contact;
        }
        if ($this->shipping_contact != null && $this->shipping_contact instanceof ContactDetails) {
            $obj['shipping_contact'] = $this->shipping_contact;
        }
        return $obj;
    }
    
}
