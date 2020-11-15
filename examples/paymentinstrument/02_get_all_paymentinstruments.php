<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//get all payment instruments
$paymentInstruments = $GloballyPaid->paymentinstrument->all('customer_id_here');

//handle errors
if (!$paymentInstruments) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $paymentInstruments list here

//example
foreach ($paymentInstruments as $pi) {
    //handle each $pi here
}

?>