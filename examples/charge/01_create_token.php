<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//Create token
$token = $GloballyPaid->token->create([
    'payment_instrument' => [
        'type' => 'creditcard',
        'creditcard' => [
            'number' => '4111111111111111',
            'expiration' => '0527',
            'cvv' => 123
        ],
        'billing_contact' => [//must be array
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
    ]
    ]);

//handle token errors
if (!$token) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $token->id here

//debug requests to api service
$GloballyPaid->debug(true);
?>