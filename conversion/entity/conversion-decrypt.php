<?php

namespace MsPhp\Conversion\Entity;

use MsPhp\App\Entity\Session;

class ConversionDecrypt extends ConversionCrypt {
    public function setResult() {
        if(is_null($this->initializationVector)){
            $initializationVector = Session::retrieve('MsPhp\Conversion\Entity\ConversionEncrypt::initializationVector');
            if($initializationVector === false){
                die();
            }
        }  else {
            $initializationVector = $this->initializationVector;
        }
        $key = openssl_digest($this->salt, 'sha256');
        $this->result = openssl_decrypt($this->value, $this->method, $key, 0, $initializationVector);
        return $this;
    }
}
