<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");

//$zengaPayAPI->status = "FAILED";
//$zengaPayAPI->per_page = 150;

$response = $zengaPayAPI->getAllCollections();

print_r($response->result);