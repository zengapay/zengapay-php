<?php
//////////////////////////////////////////////////////////////
//===========================================================
// zengaPayAPI.php (API)
//===========================================================
// ZENGAPAY PAYMENT GATEWAY
// Version: 1.0
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
    public $msisdn;
    public $amount;
    public $external_reference;
    public $narration;
    public $use_contact = false;
    public $contact_id;

    public $transactionReference;

    public $start;
    public $end;
    public $status;
    public $currency_code;
    public $per_page;
    public $designation;

    public $contact_first_name;
    public $contact_last_name;
    public $contact_phone;
    public $contact_type;
    public $contact_uuid;

    private $_host;
    private $_protocol;
    private $_APIKey;
    private $_APIVersion;
    private $_resource;
    private $_request;
    private $_params;

    /**
     * zengaPayPI constructor.
     * @param string $host
     * @param string $APIVersion
     * @param string $protocol
     */
    
    public function __construct($host="api.zengapay.com", $APIVersion ="/v1",$protocol = 'https')
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
     * All mobile money operator networks do not support this request
     * @return array
     */
    
    public function requestPayment()
    {
        $this->_resource = "/collections";
        $this->_request = array(
            "msisdn"=>$this->msisdn,
            "amount"=>$this->unformat($this->amount),
            "external_reference"=>$this->external_reference,
            "narration"=>$this->narration
        );
        return $this->sendAPIRequest('POST',$this->_resource,json_encode($this->_request));
    }
    /**
     * Check the status of a single transaction submitted for processing.
     * It can also be used to check on any other transaction on the system.
     * @param string $transactionReference: The reference to the transaction whose status you would like to follow up on. This is typically the transaction reference which came through as part of an earlier collection request response.
     * @return object
     */
    
    public function getSingleCollection()
    {
        return $this->sendAPIRequest('GET',"/collections/{$this->transactionReference}");
    }
    /**
     * Fetch all collections that were earlier submitted for processing.
     * @return object
     */
    
    public function getAllCollections()
    {
        $this->_params = array(
            "per_page"=> isset($this->per_page) ? $this->per_page : 25,
            "status"=> isset($this->status) ? $this->status : '',
            "start"=> isset($this->start) ? $this->start : date('2020-01-01 00:00:00'),
            "end"=> isset($this->end) ? $this->end : date('Y-m-d 23:59:59'),
            "currency_code"=> isset($this->currency_code) ? $this->currency_code : '',
            "designation"=> isset($this->designation) ? $this->designation : ''
        );
        return $this->sendAPIRequest('GET',"/collections",json_encode(array_merge($this->_params)));
    }
    /**
     * Transfer funds from your ZENGAPAY Account to a mobile money user
     * This transaction transfers funds from your ZENGAPAY Account to a mobile money user.
     * Please handle this request carefully because if compromised, it can lead to
     * the withdrawal of funds from your account.
     * All mobile money operator networks do not support this request
     * This request requires permission that is granted by the specific IP Address(es) whitelisted in your ZENGAPAY Dashboard
     * @return array
     */
    
    public function sendTransfer()
    {
        $this->_resource = "/transfers";
        $this->_request = array(
            "msisdn"=> isset($this->msisdn) ? $this->msisdn : '',
            "amount"=> $this->unformat($this->amount),
            "external_reference"=> $this->external_reference,
            "narration"=> $this->narration,
            "contact_id"=> isset($this->contact_id) ? $this->contact_id : '',
            "use_contact"=> isset($this->use_contact) ? (boolean) $this->use_contact : (boolean) 0
        );
        return $this->sendAPIRequest('POST',$this->_resource,json_encode($this->_request));
    }
    /**
     * Check the status of a single transaction submitted for processing.
     * It can also be used to check on any other transaction on the system.
     * @param string $transactionReference: The reference to the transaction whose status you would like to follow up on. This is typically the transaction reference which came through as part of an earlier transfer request response.
     * @return object
     */
    
    public function getSingleTransfer()
    {
        return $this->sendAPIRequest('GET',"/transfers/{$this->transactionReference}");
    }
    /**
     * Fetch all transfers that were earlier submitted for processing.
     * @return object
     */
    public function getAllTransfers()
    {
        $this->_params = array(
            "per_page"=> isset($this->per_page) ? $this->per_page : 25,
            "status"=> isset($this->status) ? $this->status : '',
            "start"=> isset($this->start) ? $this->start : date('2020-01-01 00:00:00'),
            "end"=> isset($this->end) ? $this->end : date('Y-m-d 23:59:59'),
            "currency_code"=> isset($this->currency_code) ? $this->currency_code : '',
            "designation"=> isset($this->designation) ? $this->designation : ''
        );
        return $this->sendAPIRequest('GET',"/transfers",json_encode($this->_params));
    }
    /**
     * Transfer funds from your ZENGAPAY Account to a mobile money user
     * This transaction transfers funds from your ZENGAPAY Account to a mobile money user.
     * Please handle this request carefully because if compromised, it can lead to
     * the withdrawal of funds from your account.
     * All mobile money operator networks do not support this request
     * This request requires permission that is granted by the specific IP Address(es) whitelisted in your ZENGAPAY Dashboard
     * @return array
     */
    public function registerContact()
    {
        $this->_resource = "/contacts";
        $this->_request = array(
            "first_name"=> $this->contact_first_name,
            "last_name"=> isset($this->contact_last_name) ? $this->contact_last_name : '',
            "phone"=> $this->contact_phone,
            "type"=> $this->contact_type
        );
        return $this->sendAPIRequest('POST',$this->_resource,json_encode($this->_request));
    }
    /**
     * Get Contact
     * Returns objects containing single contact
     * @return object
     */
    public function getContact()
    {
        return $this->sendAPIRequest('GET',"/contacts/{$this->contact_uuid}");
    }
    /**
     * Get All Contacts
     * Returns objects containing an array of your account contacts
     * @return object
     */
    public function getAllContacts()
    {
        return $this->sendAPIRequest('GET','/contacts');
    }
    /**
     * Get Info on your ZENGAPAY Account
     * Returns objects containing an array of account data
     * @return object
     */
    public function accountInfo()
    {
        return $this->sendAPIRequest('GET',"/account");
    }

    /**
     * Get the current balance of your ZENGAPAY Account
     * Returns objects containing an array of balances (including airtime)
     * @return object
     */
    public function accountGetBalance()
    {
        return $this->sendAPIRequest('GET',"/account/balance");
    }

    /**
     * Return an account statement object of transactions that were carried out on your account for a certain period of time
     * @param string $start format YYYY-MM-DD HH:MM:SS
     * @param string $end  format YYYY-MM-DD HH:MM:SS
     * @param string $status
     * Options
     * * "FAILED"
     * * "PENDING"
     * * "INDETERMINATE"
     * * "SUCCEEDED"
     * * "FAILED, SUCCEEDED" (comma separated)
     * @param string $currency_code
     * Options
     * * "UGX-MTNMM" -> Uganda Shillings - MTN Mobile Money
     * * "UGX-ATLMM" -> Uganda Shillings - Airtel Money
     * @param int $limit Default limit = 25
     * @param string $designation
     * Options
     * * "TRANSACTION"
     * * "CHARGES"
     * * "LIQUIDATION"
     * @return object
     */
    public function accountGetStatement()
    {
        $this->_params = array(
            "per_page"=> isset($this->per_page) ? $this->per_page : 25,
            "status"=> isset($this->status) ? $this->status : '',
            "start"=> isset($this->start) ? $this->start : date('2020-01-01 00:00:00'),
            "end"=> isset($this->end) ? $this->end : date('Y-m-d 23:59:59'),
            "currency_code"=> isset($this->currency_code) ? $this->currency_code : '',
            "designation"=> isset($this->designation) ? $this->designation : ''
        );
        return $this->sendAPIRequest('GET',"/account/statement",json_encode($this->_params));
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
     * Retrieve and set a list of headers needed for the request
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
            $headers[] = "Authorization: Bearer {$this->_APIKey}";
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60 );
        $output = new stdClass();
        $output->result = json_decode(curl_exec($ch));
        $curl_info = curl_getinfo($ch);
        $output->httpResponseCode = $curl_info['http_code'];
        curl_close($ch);
        return $output;
    }
}
