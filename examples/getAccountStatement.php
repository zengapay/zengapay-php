<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");

//$zengaPayAPI->status = "FAILED";
//$zengaPayAPI->per_page = 150;
$zengaPayAPI->designation = "LIQUIDATION";

$response = $zengaPayAPI->accountGetStatement();

print_r($response);

