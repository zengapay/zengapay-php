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
composer require zengapay/zengapay-php
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
## Collections

ZENGAPAY uses the term Collections to refer to money that you receive (or collect) from a mobile subscriber. This differentiates money you receive (Collections) from money you send to mobile subscribers (Transfers).

### Sample Payment Request (Collection)

The collections API enables you to deposit funds into your ZENGAPAY account by transferring the said funds from a mobile money account holder.

```php
   $zengaPayAPI = new zengaPayAPI("api.zengapay.com");
   $zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
   $request = $zengaPayAPI->requestPayment("256770000000",1500,"Payment Reference","Payment Narration");
   
   if($request->result->code === 202)
   {
        //Transaction was initiated successfully
        echo $request->result->transactionReference;  // You will need this to follow up on the status of the transaction in the next step
   }
   // If you wish, you may print_r to view the full response. 
   print_r($request);
```

### Getting a Single Collection (Checking status of a collection request)

To retrieve a single collection object (check status of a collection request), provide the transactionReference and a collection object will be returned.

```php
  $zengaPayAPI = new zengaPayAPI("api.zengapay.com");
  $zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
  $request = $zengaPayAPI->getSingleCollection("<YOUR_TRANSACTION_REFERENCE>");
  
    
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
  $zengaPayAPI = new zengaPayAPI("api.zengapay.com");
  $zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
  $request = $zengaPayAPI->getAllCollections();
  
  print_r($request); 
```

## Transfers

ZENGAPAY uses the term Transfers to refer to money that you send to a mobile subscriber. This differentiates money you send to mobile subscribers (aka Transfers) from money you receive from mobile subscribers (aka Collections).

### Sample Payout Request (Transfer)

The Transfers API to enables you to send money to a mobile subscriber, withdraw your funds to Mobile Money.
```php
  $zengaPayAPI = new zengaPayAPI("api.zengapay.com");
  $zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
  $transfer = $zengaPayAPI->sendTransfer("256770000000",1500,"Transfer Reference","Transfer Narration");


  if($transfer->result->code === 202)
  {
     //Transaction was initiated successfully
     echo $response->transactionReference;  // You will need this to follow up on the status of the transaction in the next step
  }
  // If you wish, you may print_r to view the full response.    
  print_r($transfer); 
```

### Getting a Single Transfer (Checking status of a transfer request)

To retrieve a single transfer object (check status of a transfer request), provide the transactionReference and a transfer object will be returned.

```php
  $zengaPayAPI = new zengaPayAPI("api.zengapay.com");
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
  $zengaPayAPI = new zengaPayAPI("api.zengapay.com");
  $zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
  $transfers = $zengaPayAPI->getAllTransfers();
  
  print_r($transfers);
```


## Related Webhooks

The `collection.success` and `collection.failed` events are triggered whenever something happens to a collection that you have initiated. For example, if it is successful or if it fails.

The `transfer.success` and `transfer.failed` events are triggered whenever something happens to a transfer that you have initiated. For example, if it is successful or if it fails.

You can configure a web link to receive notifications whenever this occurs. This will allow you to respond automatically whenever a collection or transfer is completed or whenever it fails.
 
See our [Webhooks API](https://developers.zengapay.com#webhooks-ipns) documentation for more information.

You'll find plenty more to play with in the [examples](https://github.com/zengapay/zengapay-php) folder.

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


