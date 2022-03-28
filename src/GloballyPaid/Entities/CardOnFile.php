<?php
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Entities;

/**
 * CardOnFile
 */
class CardOnFile
{
    /**
     * The id of the card on file
     * @var string
     */
    public $id;
    /**
     * The CVV - required for user attended transactions
     * @var string
     */
    public $cvv;
    
    /**
     * Constructor
     * @param string $id The id of the card on file in the GloballyPaid vault.
     * @param string $cvv The CVV on the card. Required for user attended transaction
     */
    function __construct($id, $cvv = '') {
        $this->id = $id;
        $this->cvv = $cvv;
    }
}
