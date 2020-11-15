<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//update existing paymentinstrument by id
$updatePaymentInstrument = $GloballyPaid->paymentinstrument->update('paymentinstrument_id_here',
    [
        'customer_id' => 'customer_id_here',
        'billing_contact' =>
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' =>
            [
                'line_1' => 'New address'
            ],
            'phone' => '2125551212',
            'email' => 'jdoe@example.com',
        ],
]);

//handle errors
if (!$updatePaymentInstrument) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $updatePaymentInstrument response

?>