<?php
require_once "../lib/zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI("api.zengapay.com");
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
$response = $zengaPayAPI->sendTransfer("256770000000",1500,"Transfer Reference","Transfer Narration");

print_r($response);