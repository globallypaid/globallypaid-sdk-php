<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//update existing customer
$updateExistingCustomer = $GloballyPaid->customers->update('customer_id_here',
    [
        'first_name' => 'New name',
        'last_name' => 'Smith',
        'address' => [
            'line_1' => 'New address',
        ],
        'email' => 'newemail@example123.com'
    ]
);


//handle errors
if (!$updateExistingCustomer) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $updateExistingCustomer response here

?>