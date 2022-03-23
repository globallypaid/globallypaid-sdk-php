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
namespace GloballyPaid\Entities\Requests;

use GloballyPaid\Entities\TransactionDetails;
use GloballyPaid\Entities\MetaDetails;
use GloballyPaid\Entities\PaymentSource;

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