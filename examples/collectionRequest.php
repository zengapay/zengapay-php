<?php
require_once "../lib/zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI("api.zengapay.com");
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
$response = $zengaPayAPI->requestPayment("256755********",1500,time(),"test-payment");

print_r($response);