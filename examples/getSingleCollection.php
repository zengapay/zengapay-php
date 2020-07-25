<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI("api.zengapay.com");
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
$response = $zengaPayAPI->getSingleCollection("<YOUR_TRANSACTION_REFERENCE>");

if($response->data->transactionStatus === "SUCCEEDED")
{
    //Transaction was successful and funds were deposited into your ZENGAPAY Account. You can go a head to update your system.
}
//If you wish, you may print_r to view the full response
print_r($response);
