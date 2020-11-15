<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//get existing customer by id
$existingCustomer = $GloballyPaid->customers->get('customer_id_here');

//handle errors
if (!$existingCustomer) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $existingCustomer here

?>