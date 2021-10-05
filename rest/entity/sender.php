<?php
namespace MsPhp\Rest\Entity;

use MsPhp\App\Entity\UriAbstract;

abstract class Sender {
    protected array $headers = [];
    protected $data;
    protected $url;
    const RESULT_TYPE_JSON = 'json';
    const RESULT_TYPE_TEXT = 'text';
    protected string $responseType = self::RESULT_TYPE_TEXT;
    protected $result;
    protected $init;
    protected bool $sslVerify = false;

    public function __construct() {
        $this->headers = array(
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'en-GB,en;q=0.5',
            'UserAgent' => 'Mozilla/5.0 (X11; Fedora; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0',
        );
        $this->init = curl_init();
    }
    public function setHeaders(array $headers) {
        $this->headers = $headers;
        return $this;
    }
    public function addHeader($name,$value) {
        $this->headers[$name] = $value;
        return $this;
    }
    public function setData($arrayOrString) {
        if(is_array($arrayOrString)) {
            $this->data = json_encode($arrayOrString);
        } else {
            $this->data = $arrayOrString;
        }
        return $this;
    }
    public function setIsSslVerify(bool $isSslVerify) {
        $this->sslVerify = $isSslVerify;
        return $this;
    }
    public function setUrl(UriAbstract $instance) {
        $this->url = $instance->setResult()->getResult();
        return $this;
    }
    public function setResponseType(string $responseType) {
        $this->responseType = $responseType;
        return $this;
    }
    public function setResult() {
        curl_setopt($this->init, CURLOPT_URL, $this->url);
        curl_setopt($this->init, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->init, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->init, CURLOPT_VERBOSE, true);
        if($this->sslVerify === true){
            curl_setopt($this->init, CURLOPT_SSL_VERIFYHOST, '2');
            curl_setopt($this->init, CURLOPT_SSL_VERIFYPEER, true);
        }
        $response = curl_exec($this->init);
        $code = curl_getinfo($this->init, CURLINFO_HTTP_CODE);
        curl_close($this->init);
        if ($code == 200) {
            if($this->responseType === self::RESULT_TYPE_JSON){
                $result = json_decode($response, true);
            } else {
                $result = $response;
            }
        } else {
            $result = $code;
        }
        $this->result = $result;
        return $this;
    }

    public function getResult() {
        return $this->result;
    }
}
