<?php
namespace MsPhp\Rest\Entity;

class CurlDelete extends Sender {
    public function setResult() {
        curl_setopt($this->init, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return parent::setResult();
    }
}
