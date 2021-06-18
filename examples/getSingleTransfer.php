<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");

$zengaPayAPI->transactionReference = "b4a66137-c5da-5bfd-a1f9-8861111f257b"; // UUID
$request = $zengaPayAPI->getSingleTransfer();

if($request->result->data->transactionStatus === "SUCCEEDED")
{
    //Transaction was successful and funds were deducted from your ZENGAPAY Account. You can go a head to update your system.
}
//If you wish, you may print_r to view the full response
print_r($request);
