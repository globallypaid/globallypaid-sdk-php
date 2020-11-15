<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//Create charge request
$charge = $GloballyPaid->charges->create([
    'amount' => 9.79 * 100, //amount with cents ex. 9.79 USD should be 9.79*100
    'currency' => 'usd',
    'source' => 'token_id_here',
    'metadata' =>
        [
            'client_customer_id' => '4445554'
        ]
    ]);

//handle charge errors
if (!$charge) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $charge response here


//debug requests to api service
$GloballyPaid->debug(true);

?>