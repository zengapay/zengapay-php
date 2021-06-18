<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
$request = $zengaPayAPI->getSingleCollection("<YOUR_TRANSACTION_REFERENCE>");

if($request->result->data->transactionStatus === "SUCCEEDED")
{
    //Transaction was successful and funds were deposited into your ZENGAPAY Account. You can go a head to update your system.
}
//If you wish, you may print_r to view the full response
print_r($request);
