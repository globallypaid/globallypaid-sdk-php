<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//delete existing customer by id
$response = $GloballyPaid->customers->delete('customer_id_here');

//handle errors
if (!$response) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $response here

?>