<?php

require_once "../zengaPayAPI.php";

$zengaPayAPI = new zengaPayAPI();
$zengaPayAPI->setAPIKey("<YOUR_API_KEY>");

$zengaPayAPI->contact_first_name = "Denis";
$zengaPayAPI->contact_last_name = "Ojok";
$zengaPayAPI->contact_phone = "256751000000"; // eg #3001
$zengaPayAPI->contact_type = "Beneficiary"; //eg Beneficiary,Employee,Vendor,Other

$request = $zengaPayAPI->registerContact();

if(isset($request->result->code) && ($request->result->code === 201))
{
    //Contact was registered successfully
    echo $request->result->uuid;
}
// If you wish, you may print to view the full response.
print_r($request);