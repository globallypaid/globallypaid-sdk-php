<?php
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities\Requests;

/**
 * Refund request object
 */
class Refund
{
    /**
     * The amount to refund.
     * @var int
     */
    public $amount;
    /**
     * The original charge id. Begins with ch_
     * @var string
     */
    public $charge;
    /**
     * Optional reason for the refund. e.g. Order canceled.
     * @var string
     */
    public $reason;
    
    /**
     * 
     * @param string $id
     * @param int $amount
     * @param string $reason
     */
    public function __construct($id, $amount, $reason = '')
    {
        $this->charge = $id;
        $this->amount = $amount;
        $this->reason = $reason;
    }
}

