<?php 
/**
 *
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid\Resources;

use GloballyPaid\Entities\Requests\Charge;
use GloballyPaid\Entities\PaymentSource;
use GloballyPaid\Entities\TransactionDetails;
use GloballyPaid\Entities\MetaDetails;
use GloballyPaid\Entities\Requests\Capture;
use GloballyPaid\Entities\Requests\Refund;
use GloballyPaid\Entities\ApiResponse;

/**
 * Payments Resources
 */
class PaymentResource extends Resource
{
    protected $basePath = '/api/v1/payments';
    /**
     * summary
     */
    public function __construct($config)
    {
        parent::__construct($config);
    }
    
    /**
     * Create a charge transaction with the option to capture immediately
     * @param PaymentSource $paymentSource
     * @param TransactionDetails $transactionDetails
     * @param MetaDetails $metaDetails
     * @return ApiResponse
     * @api
     */
    public function charge($paymentSource, $transactionDetails, $metaDetails)
    {
        $request = new Charge($paymentSource, $transactionDetails, $metaDetails);
        return $this->request('POST', 'charge', [], $request);
    }
    
    /**
     * Authorize a transaction
     * 
     * This is the same as calling charge() and setting `capture = false` on the TransactionDetails
     * @param PaymentSource $paymentSource
     * @param TransactionDetails $transactionDetails
     * @param MetaDetails $metaDetails
     * @return ApiResponse
     * @api
     */
    public function auth($paymentSource, $transactionDetails, $metaDetails) 
    {
        $transactionDetails->capture = false; // just to make sure...
        return $this->charge($paymentSource, $transactionDetails, $metaDetails);
    }
    
    /**
     * Capture a previously authorized charge transaction
     * @param string $id Transaction ID from a previous auth request or charge request that wasn't captured
     * @param int $amount Amount. 999 = $9.99
     * @return ApiResponse
     * @api
     */
    public function capture($id, $amount)
    {
        $request = new Capture($id, $amount);
        return $this->request('POST', 'capture', [], $request);
    }
    
    /**
     * Refund a transaction
     * 
     * This is the same as a void in terms of the API. The API will intelligently decide
     * which is performed on the card based on whether the transaction has settled or not.
     * @param string $id
     * @param int $amount
     * @param string $reason
     * @return ApiResponse
     * @api
     */
    public function refund($id, $amount, $reason = '')
    {
        $request = new Refund($id, $amount, $reason);
        return $this->request('POST', 'refund', [], $request);
    }
    
    /**
     * Void a transaction
     * 
     * This is the same as a refund in terms of the API. The API will intelligently decide
     * which is performed on the card based on whether the transaction has settled or not.
     * @param string $id
     * @param int $amount
     * @param string $reason
     * @return ApiResponse
     * @api
     */
    public function void($id, $amount, $reason = '')
    {
        return $this->refund($id, $amount, $reason);
    }
}