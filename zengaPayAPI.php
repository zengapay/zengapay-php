<?php
//////////////////////////////////////////////////////////////
//===========================================================
// zengaPayAPI.php (API)
//===========================================================
// ZENGAPAY PAYMENT GATEWAY
// Version : 1.0
// Inspired by the DESIRE to be the BEST OF ALL
// ----------------------------------------------------------
// Initial work: Denis Ojok
// Date:       10th May 2020
// Time:       23:00 hrs
// Site:       https://zengapay.com/ (ZENGAPAY LIMITED)
// ----------------------------------------------------------
// Please Read the API Documentation at https://developers.zengapay.com
// ----------------------------------------------------------
//===========================================================
// (c)ZENGAPAY LIMITED.
//===========================================================
//////////////////////////////////////////////////////////////
class zengaPayAPI
{
    private $_host;
    private $_protocol;
    private $_APIKey;
    private $_APIVersion;
    private $_resource;
    private $_request;

    /**
     * zengaPayPI constructor.
     * @param string $host
     * @param string $APIVersion
     * @param string $protocol
     */
    
    public function __construct($host, $APIVersion ="/v1",$protocol = 'https')
    {
        $this->_host = $host;
        $this->_APIVersion = $APIVersion;
        $this->_protocol = $protocol;
    }
    /**
     * Request Funds from a Mobile Money User, The requested funds will be deposited into your account
     * Shortly after you submit this request, the mobile money user receives an on-screen
     * notification on their mobile phone. The notification informs the mobile money user about
     * your request to transfer funds out of their account and requests them to authorize the
     * request to complete the transaction.
     * This request is not supported by all mobile money operator networks
     * @param string $msisdn: The mobile money phone number in the format 256772123456
     * @param double $amount: The amount of money to be deposited into your account (floats are supported)
     * @param string $external_reference: Something which yourself and the beneficiary agree upon e.g. an invoice number
     * @param string $narration: The reason for the mobile money user to deposit funds
     * @return array
     */
    
    public function requestPayment($msisdn,$amount,$external_reference,$narration)
    {
        $this->_resource = "/collections";
        $this->_request = array(
            "msisdn"=>$msisdn,
            "amount"=>$this->unformat($amount),
            "external_reference"=>$external_reference,
            "narration"=>$narration
        );
        return $this->sendAPIRequest('POST',$this->_resource,json_encode($this->_request));
    }
    /**
     * Check the status of a single transaction that was earlier submitted for processing.
     * It can also be used to check on any other transaction on the system.
     * @param string $transactionReference: The reference to the transaction whose status you would like to follow up on. This is typically the transaction reference which came through as part of an earlier collection request response.
     * @return object
     */
    
    public function getSingleCollection($transactionReference)
    {
        return $this->sendAPIRequest('GET',"/collections/{$transactionReference}");
    }
    /**
     * Fetch all collections that were earlier submitted for processing.
     * @return object
     */
    
    public function getAllCollections()
    {
        return $this->sendAPIRequest('GET',"/collections");
    }
    /**
     * Transfer funds from your ZENGAPAY Account to a mobile money user
     * This transaction transfers funds from your ZENGAPAY Account to a mobile money user.
     * Please handle this request with care because if compromised, it can lead to
     * withdrawal of funds from your account.
     * This request is not supported by all mobile money operator networks
     * This request requires permission that is granted by the specific IP Address(es) whitelisted in your ZENGAPAY Dashboard
     * @param string $msisdn the mobile money phone number in the format 256772123456
     * @param double $amount: The amount of money to withdraw from your account (floats are supported)
     * @param string $external_reference: Something which yourself and the beneficiary agree upon e.g. an invoice number
     * @param string $narration: The reason for the mobile money user to deposit funds
     * @return array
     */
    
    public function sendTransfer($msisdn,$amount,$external_reference,$narration)
    {
        $this->_resource = "/transfers";
        $this->_request = array(
            "msisdn"=>$msisdn,
            "amount"=>$this->unformat($amount),
            "external_reference"=>$external_reference,
            "narration"=>$narration
        );
        return $this->sendAPIRequest('POST',$this->_resource,json_encode($this->_request));
    }
    /**
     * Check the status of a single transaction that was earlier submitted for processing.
     * It can also be used to check on any other transaction on the system.
     * @param string $transactionReference: The reference to the transaction whose status you would like to follow up on. This is typically the transaction reference which came through as part of an earlier transfer request response.
     * @return object
     */
    
    public function getSingleTransfer($transactionReference)
    {
        return $this->sendAPIRequest('GET',"/transfers/{$transactionReference}");
    }
    /**
     * Fetch all transfers that were earlier submitted for processing.
     * @return object
     */
    
    public function getAllTransfers()
    {
        return $this->sendAPIRequest('GET',"/transfers");
    }
    /**
     * Get the current balance of your ZENGAPAY Account
     * Returns objects contains an array of balances (including airtime)
     * @return object
     */
    
    public function accountGetBalance()
    {
        return $this->sendAPIRequest('GET',"/account/balance");
    }
    /**
     * Return an account statement object of transactions which were carried out on your account for a certain period of time
     * @param string $start format YYYY-MM-DD HH:MM:SS
     * @param string $end  format YYYY-MM-DD HH:MM:SS
     * @param string $status
     * Options
     * * "FAILED"
     * * "PENDING"
     * * "INDETERMINATE"
     * * "SUCCEEDED"
     * * "FAILED,SUCCEEDED" (comma separated)
     * @param string $currency_code
     * Options
     * * "UGX-MTNMM" -> Uganda Shillings - MTN Mobile Money
     * * "UGX-ATLMM" -> Uganda Shillings - Airtel Money
     * @param int $limit Default limit = 25
     * @param string $designation
     * Options
     * * "TRANSACTION"
     * * "CHARGES"
     * * "ANY"
     * @return object
     */
    
    public function accountGetStatement($start=NULL, $end=NULL, $status=NULL, $currency_code=NULL, $limit=NULL, $designation='ANY')
    {
        return $this->sendAPIRequest('GET',"/account/statement");
    }
    /**
     * Define API key for authentication
     *
     * @param string $APIKey
     */
    
    public function setAPIKey($APIKey)
    {
        $this->_APIKey = $APIKey;
    }

    /**
     * Clean Amount before passing to API
     * @param string $number
     * @param bool $force_number
     * @param string $dec_point
     * @param string $thousands_sep
     * @return int or float
     */
    
    private function unformat($number, $force_number = true, $dec_point = '.', $thousands_sep = ',') {
        if ($force_number) {
            $number = preg_replace('/^[^\d]+/', '', $number);
        } else if (preg_match('/^[^\d]+/', $number)) {
            return false;
        }
        $type = (strpos($number, $dec_point) === false) ? 'int' : 'float';
        $number = str_replace(array($dec_point, $thousands_sep), array('.', ''), $number);
        settype($number, $type);
        return $number;
    }

    /**
     * Retrieve and set a list of headers needed for request
     *
     * @return array
     */

    private function _setHeaders()
    {
        $headers = array(
            "Content-Type:application/json",
        );
        if ($this->_APIKey)
        {
            $headers[] = "Authorization: Token {$this->_APIKey}";
        }
        return $headers;
    }

    /**
     * Perform API request
     *
     * @param string $method
     * @param string $endPoint
     * @param string $body
     * @return object
     */
    
    protected function sendAPIRequest($method,$endPoint,$body=NULL)
    {
        $ch = curl_init( );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_setHeaders());
        curl_setopt($ch, CURLOPT_URL, "{$this->_protocol}://{$this->_host}{$this->_APIVersion}{$endPoint}");
        $method == "POST" ? curl_setopt($ch, CURLOPT_POST, true) : curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        isset($body) ? curl_setopt($ch, CURLOPT_POSTFIELDS, $body) :'';
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30 );
        $output = new stdClass();
        $output->result = json_decode(curl_exec($ch));
        $curl_info = curl_getinfo($ch);
        $output->httpResponseCode = $curl_info['http_code'];
        curl_close($ch);
        return $output;
    }
}