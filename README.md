# GloballyPaid PHP SDK

The official GloballyPaid PHP client library.

## Requirements

PHP 5.6.0 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require globallypaid/php-sdk
```

```php
require_once('vendor/autoload.php');
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/globallypaid/globallypaid-sdk-php/releases). Then, to use the bindings, include the config `config.php` (you can add in your framework or application config file) and main class `GloballyPaidSDK.php` file.

```php
require_once('/path/to/globallypaid-sdk-php/src/GloballyPaidSDK.php');
```

## Dependencies

The bindings require the following extensions in order to work properly:

-   [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
-   [`json`](https://secure.php.net/manual/en/book.json.php)
-   [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Getting Started

Simple configuration looks like:

```php
//required config
$config['PublishableApiKey']    = 'PublishableApiKey_here';
$config['AppId']                = 'AppId_here';
$config['SharedSecret']         = 'SharedSecret_here';
$config['Sandbox']              = true;

//optional config
//$config['ApiVersion']          = 'v1'; //default v1
//$config['RequestTimeout']      = 10; //default 30
```

Example: initialize the Client

```php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

$GloballyPaid = new GloballyPaid($config);

//config can be changed dynamically 
$GloballyPaid->setConfig([
    'PublishableApiKey' => 'PublishableApiKey_here',
    'AppId' => 'AppId_here',
    'SharedSecret' => 'SharedSecret_here',
    'Sandbox' => true,
    'ApiVersion' => 'v1',
    'RequestTimeout' => 5
]);
```


# Documentation

Please see the [PHP API docs](https://sandbox.docs.globallypaid.com/) for the most up-to-date documentation.

You can also refer to the [GloballyPaid developers page](https://globallypaid.com/developers/).

### Example

For a working example of usage, please visit [Globally Paid PHP SDK example](https://github.com/globallypaid/globallypaid-sdk-php-samples).

## Initialize the Client

```php
$GloballyPaid = new GloballyPaid($config);
```

## Charges

### Make a Instant Charge Sale Transaction

```php
$charge = $GloballyPaid->charges->create([
    'source' => [ // the payment source object
        'type' => 'card_on_file', // either card_on_file or credit_card
        'card_on_file' => [
            'id' => 'token_id_here', // required
            'cvv' => '123', // optionally pass the CVV for user attended transactions
        ]
    ],
    'transaction' => [ // the transaction object
        'amount' => 9.79 * 100, // integer amount in the smallest currency unit, 979 = 9.79
        'currency_code' => 'USD', // ISO 4217 currency code
        'country_code' => 'USA', // ISO 3166 Alpha-3 country code
        'capture' => false, // false = authorization only, true = sale
        'avs' => true, // perform address verification
        'cof_type' => 'UNSCHEDULED_CARDHOLDER', // one of UNSCHEDULED_CARDHOLDER | UNSCHEDULED_MERCHANT | RECURRING | INSTALLMENT
        'kount_session_id' => 'session id',
        'save_payment_instrument' => false // if true, will save the payment instrument in our vault. We will return a payment instrument id that can be used for future payments.

    ]
    'meta' => [ // the metadata object
        'client_customer_id' => '123456', //your customer id
        'client_transaction_id' => '987654', // your transaction id
        'client_transaction_description' => 'Acme T-Shirt', // a short description for the transaction
        'client_invoice_id' => 'INV-01293', // your invoice id
        'shipping_info' => [ // shipping info for this transaction if available/applicable
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' => [
                'line_1' => '123 Any St',
                'line_2' => 'Apt B',
                'city' => 'Irvine',
                'state' => 'CA',
                'postal_code' => '92714',
                'country_code' => 'USA'
            ],
            'phone' => '9495551212',
            'email' => 'jdoe@nopmail.com'
        ]

    ]
]);
```

### Make a Charge Sale Transaction With Capture 

The transaction amount doesn’t reach the merchant account until the funds are captured.

```php
//charge request
$charge = $GloballyPaid->charges->create([
    'source' => [ 
        'type' => 'card_on_file', 
        'card_on_file' => [
            'id' => 'token_id_here', 
        ]
    ],
    'transaction' => [ 
        'amount' => 9.79 * 100, 
        'currency_code' => 'USD',
        'country_code' => 'USA',
        'capture' => false,
        'avs' => true,
        'cof_type' => 'UNSCHEDULED_CARDHOLDER', 
        'kount_session_id' => 'session id',

    ]
    'meta' => [ 
        'client_customer_id' => '123456', 
        'client_transaction_id' => '987654',
        'client_transaction_description' => 'Acme T-Shirt',
        'client_invoice_id' => 'INV-01293',
        'shipping_info' => [ 
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' => [
                'line_1' => '123 Any St',
                'line_2' => 'Apt B',
                'city' => 'Irvine',
                'state' => 'CA',
                'postal_code' => '92714',
                'country_code' => 'USA'
            ],
            'phone' => '9495551212',
            'email' => 'jdoe@nopmail.com'
        ]

    ]
]);

//capture request
$capture = $GloballyPaid->charges->capture(
    $charge->id,
    $charge->amount
);
```

### Refund request 

```php
$refund = $GloballyPaid->charges->refund(
    'charge_id_here',
    20 * 100 // amount
);
```

## Customers

### Create customer

```php
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
```

### Get all customers

```php
$customers = $GloballyPaid->customers->all();

foreach($customers as $customer){
    //handle each $customer here
}
```

### Get customer by id

```php
$existingCustomer = $GloballyPaid->customers->get('customer_id_here');
```

### Update existing customer

```php
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
```

### Delete existing customer

```php
$response = $GloballyPaid->customers->delete('customer_id_here');
```

#### Similar to customer crud is PaymentInstrument. You can check stand-alone examples to learn how to use.

## Handling errors

You can handle errors for each request on same way `$GloballyPaid->errors()`. Check the example below:

```php
require_once '../../config/config.php';
require_once '../../src/GloballyPaidSDK.php';

//init class object
$GloballyPaid = new GloballyPaid($config);

//get existing customer by id
$existingCustomer = $GloballyPaid->customers->get('customer_id_here');

//if customer doesn't exist or any error happened -> handle errors
if (!$existingCustomer) {
    $errors = $GloballyPaid->errors();
    echo '<pre>';
    var_dump($errors);
    echo '</pre>';
}
```

## Debug and trace API calls (requests and responses)

### Print debug data in formated pre tag
```php
$GloballyPaid->debug(true);
```

### Return debug data as array
You can use this way if you want to embed debug with your framework or application
```php
$debugArrayData = $GloballyPaid->debug();
```

# About

globallypaid-php-sdk is maintained and funded by Globally Paid. If you need help installing or using the library, please check the [GloballyPaid Support Help Center](https://globallypaid.com/contact-us/).

If you've instead found a bug in the library or would like new features added, go ahead and open issues or pull requests against this repo [GloballyPaid PHP SDK](https://github.com/globallypaid/globallypaid-sdk-php)!
