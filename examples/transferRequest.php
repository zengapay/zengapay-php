<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI("api.zengapay.com");
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
$response = $zengaPayAPI->sendTransfer("256770000000","1500","Transfer Reference","Transfer Narration");

if($response->result->code === 202)
{
    //Transaction was initiated successfully
    echo $response->result->transactionReference;  // You will need this to follow up on the status of the transaction in the next step
}
// If you wish, you may print to view the full response. 
print_r($response);