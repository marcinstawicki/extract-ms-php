<?php
namespace MsPhp\Rest\Entity;

class CurlPut extends Sender {
    public function setResult() {
        curl_setopt($this->init, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->init, CURLOPT_POSTFIELDS, $this->data);
        return parent::setResult();
    }
}
