<?php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//capture request
$capture = $GloballyPaid->charges->capture(
    $charge->id,
    $charge->amount
);

//handle capture errors
if (!$capture) {
    echo '<pre>' . print_r($GloballyPaid->errors(), true) . '</pre>';
}

//do anything with $capture response here


//debug requests to api service
$GloballyPaid->debug(true);

?>