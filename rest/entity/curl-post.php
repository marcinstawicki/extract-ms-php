<?php
namespace MsPhp\Rest\Entity;

class CurlPost extends Sender {
    public function setResult() {
        curl_setopt($this->init, CURLOPT_POST, true);
        curl_setopt($this->init, CURLOPT_POSTFIELDS, $this->data);
        return parent::setResult();
    }
}
