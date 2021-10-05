<?php

namespace MsPhp\Conversion\Entity;

use MsPhp\App\Entity\Session;

abstract class ConversionCrypt extends Conversion {
    /**
     *  OPENSSL_RAW_DATA und OPENSSL_ZERO_PADDING.
     *  give it as default
     */
    protected $initializationVector;
    protected $salt;
    protected $result;
    const METHOD_AES_128_CBC = 'AES-128-CBC';
    const METHOD_AES_128_CFB = 'AES-128-CFB';
    const METHOD_AES_128_OFB = 'AES-128-OFB';
    const METHOD_AES_256_CBC = 'AES-256-CBC';
    const METHOD_AES_256_CFB = 'AES-256-CFB';
    const METHOD_AES_256_OFB = 'AES-256-OFB';
    const METHOD_BF_CBC = 'BF-CBC';
    const METHOD_BF_CFB = 'BF-CFB';
    const METHOD_BF_OFB = 'BF-OFB';
    protected $method = self::METHOD_AES_128_CBC;
    public function __construct() {
        $this->salt = 'fRh@iQo8%4qHPp11h?p1&';
    }
    public function setMethod($method = self::METHOD_AES_128_CBC) {
        $this->method = $method;
        return $this;
    }
    public function setInitializationVector($initializationVector) {
        $this->initializationVector = $initializationVector;
        return $this;
    }
    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }
    public function setResult() {
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}
