<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//fetch all customers
$customers = $GloballyPaid->customers->all();

//handle errors
if (!$customers) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $customers list here

//example
foreach($customers as $customer){
    //handle each $customer here
}
?>