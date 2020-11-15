<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//create payemnt instrument
$newPaymentInstrument = $GloballyPaid->paymentinstrument->create([
    'customer_id' => 'existing_customer_id_here',
    'client_customer_id' => 'customer_id_from_your_system',
    'type' => 'creditcard',
    'creditcard' => [
        'number' => '4111111111111111',
        'expiration' => '0627',
        'cvv' => 361
    ],
    'billing_contact' => [
        'first_name' => 'Test',
        'last_name' => 'Tester',
        'address' => [
            'line_1' => '123 Main St',
            'line_2' => null,
            'city' => 'NYC',
            'state' => 'NY',
            'postal_code' => '92657',
            'country' => 'United States'
        ],
        'phone' => '614-340-0823',
        'email' => 'email@test.com'
    ]
]);

//handle errors
if (!$newPaymentInstrument) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $newPaymentInstrument response here

?>