<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI("api.zengapay.com");
$zengaPayAPI->setAPIKey("ZPYPUBK-59cb6a2b82c7aad571935c47df71dba8aefeabd2267b21ec4c57e91d0f8c742d");
$response = $zengaPayAPI->accountGetBalance();

print_r($response->result);

