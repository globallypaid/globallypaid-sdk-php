<?php 
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

/**
 * Transaction details
 * 
 * This object is used to define the `transaction` object passed to the API
 */
class TransactionDetails
{
    /**
     * The amount for this transaction.
     * In whole numbers. 1995 = $19.95 * 100
     * @var integer
     */
    public $amount;
    
    /**
     * Captures a charge immediately if set to true
     * @var boolean
     */
    public $capture = false;
    
    /**
     * The ISO 3-letter currency code for the charge. e.g. 'USD' or 'CAD'
     * @var string
     */
    public $currency_code;
    
    /**
     * Performs an AVS check for a charge
     * @var boolean
     */
    public $avs = false;
    
    /**
     * Save's a payment instrument in our vault upon successful charge
     * 
     * If using a CardOnFileSource using a tok_ token or using a CreditCardSource
     * setting this to true will save the card data in our vault permanently
     * @var boolean
     */
    public $save_payment_instrument = false;
    
    /**
     * COF type
     * @var string
     */
    public $cof_type = 'UNSCHEDULED_CARDHOLDER';
    
    /**
     * Create a new TransactionDetails object
     * @param integer $amount
     * @param string $currency_code
     * @param boolean $capture
     */
    public function __construct($amount, $currency_code, $capture = false)
    {
        $this->amount = $amount;
        $this->currency_code = $currency_code;
        $this->capture = $capture;
    }
    
}