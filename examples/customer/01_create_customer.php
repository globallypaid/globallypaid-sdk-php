<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//create new customer
$newCustomer = $GloballyPaid->customers->create([
    'client_customer_id' => 'client_customer_id_here',
    'first_name' => 'John',
    'last_name' => 'Smith',
    'address' => [
        'line_1' => '123 Main St',
        'line_2' => null,
        'city' => 'NYC',
        'state' => 'NY',
        'postal_code' => '92657',
        'country' => 'United States'
    ],
    'phone' => '+123456789',
    'email' => 'testemail@example.com'
]);

//handle errors
if (!$newCustomer) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $newCustomer response

?>