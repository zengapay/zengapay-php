<?php
require_once "../lib/zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI("api.zengapay.com");
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
$response = $zengaPayAPI->getSingleTransfer("<YOUR_TRANSACTION_REFERENCE>");

print_r($response);
