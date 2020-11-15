<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//get existing paymentinstrument by id
$singlePaymentInstrument = $GloballyPaid->paymentinstrument->get('paymentinstrument_id_here');

//handle errors
if (!$singlePaymentInstrument) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $singlePaymentInstrument response

?>