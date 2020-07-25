<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI("api.zengapay.com");
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
$request = $zengaPayAPI->requestPayment("256770000000","1500","Your Payment Reference","Your Payment Narration");

if($request->result->code === 202)
{
    //Transaction was initiated successfully
    echo $request->result->transactionReference;  // You will need this to follow up on the status of the transaction in the next step
}
// If you wish, you may print to view the full response.
print_r($request);