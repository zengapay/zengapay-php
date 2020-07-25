<?php


class zengaPayAPI
{
    private $_host;
    private $_protocol;
    private $_APIKey;
    private $_APIVersion;
    private $_resource;
    private $_request;

    public function __construct($host, $APIVersion ="/v1",$protocol = 'https')
    {
        $this->_host = $host;
        $this->_APIVersion = $APIVersion;
        $this->_protocol = $protocol;
    }

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
    public function getSingleCollection($transactionReference)
    {
        return $this->sendAPIRequest('GET',"/collections/{$transactionReference}");
    }
    public function getAllCollections()
    {
        return $this->sendAPIRequest('GET',"/collections");
    }
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
    public function getSingleTransfer($transactionReference)
    {
        return $this->sendAPIRequest('GET',"/transfers/{$transactionReference}");
    }
    public function getAllTransfers()
    {
        return $this->sendAPIRequest('GET',"/transfers");
    }
    public function accountGetBalance()
    {
        return $this->sendAPIRequest('GET',"/account/balance");
    }
    public function accountGetStatement()
    {
        return $this->sendAPIRequest('GET',"/account/statement");
    }
    /**
     * Define secret key for alternative authentication
     *
     * @param string $APIKey
     */
    public function setAPIKey($APIKey)
    {
        $this->_APIKey = $APIKey;
    }
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
     * Retrieve list of headers needed for request
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