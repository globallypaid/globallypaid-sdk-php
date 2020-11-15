<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//create refund request
$refund = $GloballyPaid->charges->refund(
    'charge_id_here',
    20 * 100 // amount
);

//handle refund errors
if (!$refund) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $refund response here

//debug requests to api service
$GloballyPaid->debug(true);

?>