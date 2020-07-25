<?php
require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI("api.zengapay.com");
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
$response = $zengaPayAPI->accountGetStatement();

print_r($response);

