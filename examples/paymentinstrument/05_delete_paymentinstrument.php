<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//delete existing paymentinstrument by id
$deleteResponse = $GloballyPaid->paymentinstrument->delete('paymentinstrument_id_here');

//handle errors
if (!$deleteResponse) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $deleteResponse response

?>