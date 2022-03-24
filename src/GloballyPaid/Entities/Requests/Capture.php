<?php
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities\Requests;

class Capture
{
    /**
     * The id of the charge request
     * @var string
     */
    public $charge;
    /**
     * The amount to capture
     * @var integer
     */
    public $amount;
    
    /**
     * 
     * @param string $id
     * @param int $amount
     */
    public function __construct($id, $amount)
    {
        $this->charge = $id;
        $this->amount = $amount;
    }
}

