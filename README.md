# GloballyPaid PHP SDK

The official GloballyPaid PHP client library.

## Requirements

PHP 7.2.5 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require globallypaid/php-sdk
```

```php
require_once('vendor/autoload.php');
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/globallypaid/globallypaid-sdk-php/releases). You will have to manage including all the proper file references starting from `GloballyPaid/GloballyPaid.php`. While this is not terribly difficult, it would be rather tedious. Using a custom autoloader is also an option as the class/file structure adheres to the PSR-4 spec. Just map `GloballyPaid\\` namespace to `/custom/install/globallypaid-sdk-php/src/GloballyPaid`

```php
require_once('/path/to/globallypaid-sdk-php/src/GloballyPaid/GloballyPaid.php');
```

## Dependencies

The bindings require the following extensions in order to work properly:

-	[`guzzlehttp\guzzle`](https://docs.guzzlephp.org/en/stable/index.html)
-   [`curl`](https://secure.php.net/manual/en/book.curl.php), not required, but recomended
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

// optional config
// $config['RequestTimeout']      = 30; // default 10
// $config['ReturnArrays']      = true; // default false 
```

**NB** ReturnArrays configuration controls how the JSON response is parsed. The default is to return `stdClass` objects. If you prefer to handle associative arrays, set this value to `true`.


Example: initialize the Client

```php
$GloballyPaid = new GloballyPaid($config);

// config can be changed dynamically 
$GloballyPaid->setConfig([
    'PublishableApiKey'  => 'PublishableApiKey_here',
    'AppId'              => 'AppId_here',
    'SharedSecret'       => 'SharedSecret_here',
    'Sandbox'            => true,
    'RequestTimeout'     => 5,
    'ReturnArrays'       => false
]);
```

**NB** This SDK uses magic methods to load classes into a static map of instances. Calling `setConfig` will replace those instances with the new versions using the new config. 




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

The `PaymentsResource::charge()` takes three parameters: a PaymentSource, TransactionDetails & MetaDetails.

#### PaymentSource
There are two types of PaymentSource objects which can be passed to the charge API. 

**CardOnFileSource** - If you are using the GloballyPaid Forms SDK to tokenize credit cards, or you using GloballyPaid's vault to store your customer's credit card data, you will use the CardOnFileSource object.
```php
$paymentSource = new GloballyPaid\Entities\CardOnFileSource();
$paymentSource->card_on_file = new GloballyPaid\Entities\CardOnFile($token_id, $cvv);
// You can also pass billing and shipping details with a payment source.
// if you do not pass billing details in the payment source, we will use
// what we collected when the credit card was tokenized the first time.
$billing_contact = new GloballyPaid\Entities\ContactDetails();
$billing_contact->first_name = 'Billy';
$billing_contact->last_name = 'Bobertson';
$billing_contact->phone = '2135551212';

$address = new GloballyPaid\Entities\Address();
$address->line_1 = '1234 Any St';
$address->line_2 = 'Apt 2a';
$address->city = 'Beverly Hills';
$address->state = 'CA';
$address->postal_code = '90210';
$address->country_code = 'USA';

$billing_contact->address = $address;

// add the billing_contact to the paymentSource
$paymentSource->billing_contact = $billing_contact;

// $paymentSource->shipping_contact takes the same ContactDetails object
```

**CreditCardSource** - If you're not using GloballyPaid to store credit card data or tokenizing via the Forms SDK and just want to pass actual credit card data, use the CreditCardSource object.
```php
$paymentSource = new GloballyPaid\Entities\CreditCardSource();
$paymentSource->credit_card = new GloballyPaid\Entities\CreditCard($account_number, $expiration, $cvv);

$billing_contact = new GloballyPaid\Entities\ContactDetails();
$billing_contact->first_name = 'Billy';
$billing_contact->last_name = 'Bobertson';
$billing_contact->phone = '2135551212';

$address = new GloballyPaid\Entities\Address();
$address->line_1 = '1234 Any St';
$address->line_2 = 'Apt 2a';
$address->city = 'Beverly Hills';
$address->state = 'CA';
$address->postal_code = '90210';
$address->country_code = 'USA';

$billing_contact->address = $address;

// add the billing_contact to the paymentSource
$paymentSource->billing_contact = $billing_contact;

// $paymentSource->shipping_contact takes the same ContactDetails object
```

#### TransactionDetails

|Property|Description|Default|
|---|---|---|
|`$amount`|An integer value of the amount to charge. e.g. if the amount is `$5.95`, pass `595` (5.95 * 100)||
|`$currency_code`|ISO 3166 3-letter currency code. e.g. `USD` or `CAD`||
|`$capture`|If you want to capture the charge immediately, set this to true|`false`|
|`$avs`|If you want to turn on address verification checks, set this to true|`false`|
|`$save_payment_instrument`|if you use CreditCardSource or a CardOnFile with `tok_` token_id and want to save the payment source in the Globally Paid vault, set to true|`false`|
|`$cof_type`|This is the COF type. _Needs description_|`UNSCHEDULED_CARDHOLDER`|

```php
$transactionDetails = new GloballyPaid\Entities\TransactionDetails($amount, $currency_code);
$transactionDetails->avs = true;
```
#### MetaDetails
This is details about the transaction that can be added for reporting purposes
|Property|Description|Default|
|---|---|---|
|`$client_transaction_id`|Somthing to identify the transaction in your system||
|`$client_transaction_description`|A brief description of the transaction||
|`$client_customer_id`|Something to identify the customer in your system||
|`$client_invoice_id`|Something to identify the invoice of for the transaction||

```php
$metaDetails = new GloballyPaid\Entities\MetaDetails();
$metaDetails->client_transaction_id = '43233344';
$metaDetails->client_invoice_id = 'inv-20220324';
$metaDetails->client_transaction_description = 'Initiation fees';
```

```php
$charge = $GloballyPaid->payments->charge($paymentSource, $transactionDetails, $metaDetails);

if ($charge->status == 200 && $charge->payload->approved == true) {
    // charge was approved and ready for capture
}
```

### Make a Charge Sale Transaction With Capture 

The transaction amount doesn’t reach the merchant account until the funds are captured.

```php
//charge request
$charge = $GloballyPaid->payments->charge($paymentSource, $transactionDetails, $metaDetails);

//capture request
$capture = $GloballyPaid->payments->capture(
    $charge->payload->id,
    $charge->payload->amount
);
```

### Refund request 

```php
$refund = $GloballyPaid->payments->refund(
    $charge->payload->id,
    $charge->payload->amount // amount
);
```

## Customers

### Create customer

```php
$newCustomer = $GloballyPaid->customer->create([
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
$customers = $GloballyPaid->customer->list();

foreach($customers as $customer){
    //handle each $customer here
}
```

### Get customer by id

```php
$existingCustomer = $GloballyPaid->customer->get('customer_id_here');
```

### Update existing customer

```php
$updateExistingCustomer = $GloballyPaid->customer->update('customer_id_here',
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
$response = $GloballyPaid->customer->delete('customer_id_here');
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
