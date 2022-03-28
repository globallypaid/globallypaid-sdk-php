<?php
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities\Requests;

use GloballyPaid\Entities\PaymentInstrument;

/**
 * Token request object
 */
class Token
{
    /**
     * 
     * @var PaymentInstrument
     */
    public $payment_instrument;
    
    /**
     * 
     * @param PaymentInstrument $paymentInstrument
     */
    public function __construct($paymentInstrument = null)
    {
        $this->payment_instrument = $paymentInstrument;
    }
    
}

