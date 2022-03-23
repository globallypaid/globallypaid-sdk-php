<?php 
/**
 * Copyright © 2022 Global Payroll Gateway, Inc
 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the “Software”), to deal in the
 * Software without restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the
 * Software, and to permit persons to whom the Software is furnished to do so, subject
 * to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @license MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

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

class CardOnFileSource extends PaymentSource  implements \JsonSerializable
{
    public $type = 'card_on_file';
    /**
     * CardOnFile
     * @var CardOnFile
     */
    public $card_on_file;
    
    
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

class CreditCardSource extends PaymentSource  implements \JsonSerializable
{
    public $type = 'credit_card';
    /**
     * CreditCard
     * @var CreditCard
     */
    public $credit_card;

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

