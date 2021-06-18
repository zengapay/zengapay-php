# ZENGAPAY PHP Library

ZENGAPAY is a Payments Gateway service that enables businesses to receive payments from their customers via mobile money, as well as make mobile money payments to any mobile money account holder or purchase Mobile Airtime or Mobile Data.

This is the Official ZENGAPAY PHP Client Library

## Getting Started

### Prerequisites

To use the API, you must, first of all, have a ZENGAPAY Account.

We have production as well as test server environments. The test server environment is called [sandbox](https://dashboard.sandbox.zengapay.com).

You are advised to [signup for a free account in sandbox](https://dashboard.sandbox.zengapay.com/sign-up), get your API Token by going to Settings → Developer Settings and test all your API calls on the sandbox environment before pointing your application to [production](https://dashboard.zengapay.com).

To point an application to production, you need to [signup for a free account in production](https://dashboard.zengapay.com/sign-up) then make only minor changes. In most cases, you simply need to change the API service `URL` and `API TOKEN`.

The API Endpoint for our sandbox environment is:

```
https://api.sandbox.zengapay.com/v1/
```

And the API Endpoint for our production environment is:

```
https://api.zengapay.com/v1/
```

### Installing

The ZENGAPAY PHP Library is available via [Composer/Packagist](https://packagist.org/packages/zengapay/zengapay-php). So just add this line to your ```composer.json``` file

```json
{
  "require": {
    "zengapay/zengapay-php": "*"
  }
}
```
or

```
composer require zengapay/zengapay-php:dev-master
```

Then inside your PHP script, add the line

```php
require 'vendor/autoload.php';
```

### Manual Installation

Alternatively, download the contents of the `zengapay-php folder` and uncompress it in a location that's on your project's include path.

Once that's done, include the library in your scripts as follows:

```php
require_once '/path/to/zengaPayAPI.php';
``` 

Depending on your preferred environment, you can Instantiate the library as follows:

```php
$zengaPayAPI = new zengaPayAPI("api.sandbox.zengapay.com"); // For Sandbox
```

```php
$zengaPayAPI = new zengaPayAPI("api.zengapay.com"); // For Production
```

**Please Note:** If you don't explicitly specify the environment, by default the library shall use the production environment

## Collections

ZENGAPAY uses the term Collections to refer to money that you receive (or collect) from a mobile subscriber. This differentiates money you receive (Collections) from money you send to mobile subscribers (Transfers).

### Sample Payment Request (Collection)

The **requestPayment** method enables you to request/collect funds from your customer(s) or any mobile money account holder and deposit the funds into your ZENGAPAY account.

```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>"); // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)

$zengaPayAPI->msisdn = "256770000000";
$zengaPayAPI->amount = 15000;
$zengaPayAPI->external_reference = "Your Transfer Reference"; // eg #3001
$zengaPayAPI->narration = "Your Transfer Narration"; //eg Refund for Order #3001

$request = $zengaPayAPI->requestPayment();

if(isset($request->result->code) && ($request->result->code === 202))
{
    //Transaction was initiated successfully
    echo $request->result->transactionReference;  // You will need this to follow up on the status of the transaction in the next step
}
// If you wish, you may print to view the full response.
print_r($request);
```

### Getting a Single Collection (Checking status of a collection request)

To retrieve a single collection object (check status of a collection request), provide the transactionReference and a collection object will be returned.

```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();   
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");  // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)

$zengaPayAPI->transactionReference = "<YOUR_TRANSACTION_REFERENCE>"; 

$request = $zengaPayAPI->getSingleCollection(); 
    
if($request->result->data->transactionStatus === "SUCCEEDED")
{
    //Transaction was successful and funds were deposited onto your ZENGAPAY Account. You can go a head to update your system. 
}
//If you wish, you may print_r to view the full response
print_r($request);
```

### Getting All Collections

Use this method to retrieve a list of all collections on your account

```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();
   
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>"); // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)

//$zengaPayAPI->status = ""; could be one of these:  FAILED,SUCCEEDED,PENDING
//$zengaPayAPI->per_page = 50;
//$zengaPayAPI->designation = ""; could be one of these : CHARGES,TRANSACTION
//$zengaPayAPI->start = "YYYY-MM-DD HH:MM:SS";
//$zengaPayAPI->end = "YYYY-MM-DD HH:MM:SS";

$request = $zengaPayAPI->getAllCollections();
  
print_r($request); 
```

## Transfers

ZENGAPAY uses the term Transfers to refer to money that you send to a mobile subscriber. This differentiates money you send to mobile subscribers (aka Transfers) from money you receive from mobile subscribers (aka Collections).

### Sample Transfer Request (Payout/Withdraw)

The **sendTransfer** method enables you to send money to a any mobile money account holder or withdraw your funds (ZENGAPAY account balance) to your own Mobile Money account.

#### Example 1: Sending to Non Contact
```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>"); // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)

$zengaPayAPI->msisdn = "256770000000";
$zengaPayAPI->amount = 1500;
$zengaPayAPI->external_reference = "Your Transfer Reference"; // #3001
$zengaPayAPI->narration = "Your Transfer Narration"; //eg Refund for Order #3001

$request = $zengaPayAPI->sendTransfer();

if(isset($request->result->code) && ($request->result->code === 202))
{
    //Transaction was initiated successfully
    echo $request->result->transactionReference;  // You will need this to follow up on the status of the transaction in the next step
}
// If you wish, you may print to view the full response. 
print_r($request);
```
#### Example 2: Sending to a Contact
```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>"); // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)

$zengaPayAPI->amount = 1500;
$zengaPayAPI->narration = "Your Transfer Narration"; //eg Refund for Order #3001
$zengaPayAPI->external_reference = "Your Transfer Reference"; // #3001
$zengaPayAPI->use_contact = true;
$zengaPayAPI->contact_id = "9aa3bc79-583e-4eb5-93bf-0e894b07aec9";

$request = $zengaPayAPI->sendTransfer();

if(isset($request->result->code) && ($request->result->code === 202))
{
    //Transaction was initiated successfully
    echo $request->result->transactionReference;  // You will need this to follow up on the status of the transaction in the next step
}
// If you wish, you may print to view the full response.
print_r($request);
```
### Getting a Single Transfer (Checking status of a transfer request)

To retrieve a single transfer object (check status of a transfer request), provide the transactionReference and a transfer object will be returned.

```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
    
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();
    
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
$transfer = $zengaPayAPI->getSingleTransfer("<YOUR_TRANSACTION_REFERENCE>");
  
if($transfer->result->data->transactionStatus === "SUCCEEDED")
{
   //Transaction was successful and funds were deducted from your ZENGAPAY Account. You can go a head to update your system. 
}
//If you wish, you may print_r to view the full response  
print_r($transfer);
```

### Getting All Transfers

Use this method to retrieve a list of all transfers on your account

```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();   
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>"); // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)

//$zengaPayAPI->status = ""; could be one of these:  FAILED,SUCCEEDED,PENDING
//$zengaPayAPI->per_page = 50;
//$zengaPayAPI->designation = ""; could be one of these : CHARGES,TRANSACTION
//$zengaPayAPI->start = "YYYY-MM-DD HH:MM:SS";
//$zengaPayAPI->end = "YYYY-MM-DD HH:MM:SS";

$transfers = $zengaPayAPI->getAllTransfers();
  
print_r($transfers);
```
## Contacts
Contacts represent people whom you can transfer funds to, or collect funds from. The contacts api method allows you to add, retrieve, list and update contacts in your account.

### Adding a contact
```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();  
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>"); // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)

$zengaPayAPI->contact_first_name = "Denis";
//$zengaPayAPI->contact_last_name = "Ojok"; // Optional
$zengaPayAPI->contact_phone = "256770000000"; // eg #256770000000
$zengaPayAPI->contact_type = "Beneficiary"; //eg Beneficiary,Employee,Vendor,Other

$request = $zengaPayAPI->registerContact();

if(isset($request->result->code) && ($request->result->code === 201))
{
    //Contact was registered successfully
    echo $request->result->uuid;
}
// If you wish, you may print to view the full response.
print_r($request);
```
### Getting all contacts
```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();  
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>"); // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)

$contacts = $zengaPayAPI->getAllContacts();
// If you wish, you may print to view the full response.
print_r($contacts);
```
### Getting a single Contact
```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();  
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>"); // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)

$zengaPayAPI->contact_uuid = "<YOUR_CONTACT_UUID>"; // eg 20a9e36e-075f-5b24-9f87-fa050c9be68f
$contact = $zengaPayAPI->getContact();

// If you wish, you may print to view the full response.
print_r($contact);
```
## Account

### Account Balance

Use the **accountGetBalance** method to get your current ZENGAPAY account balance.

```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();
   
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>"); // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)
$balance = $zengaPayAPI->accountGetBalance();
  
print_r($balance);
```

### Account Statement

Use the **accountGetStatement** method to retrieve a list of all transactions performed on your account (account statement).

```php
//require ZENGAPAY PHP Library
require_once '/path/to/zengaPayAPI.php';
   
//Instantiate the library
$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>"); // Obtain this from your ZENGAPAY Dashboard (Settings -> Developer Settings)

//$zengaPayAPI->status = ""; could be one of these:  FAILED,SUCCEEDED,PENDING
//$zengaPayAPI->per_page = 50;
//$zengaPayAPI->designation = ""; could be one of these : CHARGES,TRANSACTION,LIQUIDATION
//$zengaPayAPI->start = "YYYY-MM-DD HH:MM:SS";
//$zengaPayAPI->end = "YYYY-MM-DD HH:MM:SS";
//$zengapayAPI->currency_code = "" could be one of these: UGX-MTNMM,UGX-ATLMM 

$statement = $zengaPayAPI->accountGetStatement();
  
print_r($statement);
```

## Related Webhooks

The `collection.success` and `collection.failed` events are triggered whenever something happens to a collection that you have initiated. For example, if it is successful or if it fails.

The `transfer.success` and `transfer.failed` events are triggered whenever something happens to a transfer that you have initiated. For example, if it is successful or if it fails.

You can configure a web link to receive notifications whenever this occurs. This will allow you to respond automatically whenever a collection or transfer is completed or whenever it fails.
 
See our [Webhooks API](https://developers.zengapay.com#webhooks-ipns) documentation for more information.

You'll find plenty more to play with in the [examples](https://github.com/zengapay/zengapay-php/tree/master/examples) folder.

That's it! You should now be ready to use the ZENGAPAY PHP Library


## Developer Documentation

Checkout the official ZENGAPAY API documentation.

[https://developers.zengapay.com](https://developers.zengapay.com)

## Built With

* [PHP](http://www.php.net/) - PHP Programming Language 

## Authors

* **Denis Ojok** - *Initial work* - [ZENGAPAY LIMITED](https://github.com/zengapay)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details


