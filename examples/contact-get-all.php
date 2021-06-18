<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");

$request = $zengaPayAPI->getAllContacts();

// If you wish, you may print to view the full response.
print_r($request);
