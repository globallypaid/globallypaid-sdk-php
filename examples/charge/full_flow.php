<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

$GloballyPaid = new GloballyPaid();

//set dynamic config
$GloballyPaid->setConfig([
    'PublishableApiKey' => 'PublishableApiKey_here',
    'AppId' => 'AppId_here',
    'SharedSecret' => 'SharedSecret_here',
    'Sandbox' => true,
    'ApiVersion' => 'v1',
    'RequestTimeout' => 5
]);


//create token
$token = $GloballyPaid->token->create([
    'payment_instrument' => [
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
    ]
    ]);

//handle token errors
if (!$token) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//charge request
$charge = $GloballyPaid->charges->create([
    'amount' => 2000,
    'currency' => 'usd',
    'source' => $token->id,
    'capture' => false,
    'metadata' => ['client_customer_id' => '4445554']
]);

//handle charge errors
if (!$charge) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//capture request
$capture = $GloballyPaid->charges->capture(
    $charge->id,
    $charge->amount
);

//handle capture errors
if (!$capture) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//print response
echo '<pre>' . print_r($capture, true) . '</pre>';



//debug requests
$GloballyPaid->debug(true);

?>