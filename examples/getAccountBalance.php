<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");
$response = $zengaPayAPI->accountGetBalance();

print_r($response->result);

