<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");

$zengaPayAPI->contact_uuid = "20a9e36e-075f-5b24-9f87-fa050c9be68f"; //eg 20a9e36e-075f-5b24-9f87-fa050c9be68f
$request = $zengaPayAPI->getContact();

// If you wish, you may print to view the full response.
print_r($request);
