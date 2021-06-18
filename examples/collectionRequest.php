<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");

$zengaPayAPI->msisdn = "256770000000";
$zengaPayAPI->amount = 15500;
$zengaPayAPI->external_reference = "Your Transfer Reference"; // eg #3001
$zengaPayAPI->narration = "Your Transfer Narration"; //eg Refund for Order #3001

$request = $zengaPayAPI->requestPayment();

if($request->result->code === 202)
{
    //Transaction was initiated successfully
    echo $request->result->transactionReference;  // You will need this to follow up on the status of the transaction in the next step
}
// If you wish, you may print to view the full response.
print_r($request);