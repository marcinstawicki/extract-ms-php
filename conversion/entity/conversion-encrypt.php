<?php

namespace MsPhp\Conversion\Entity;

use MsPhp\App\Entity\Session;

class ConversionEncrypt extends ConversionCrypt {
    public function setResult() {
        if(is_null($this->initializationVector)){
            $initializationVector = Session::retrieve('MsPhp\Conversion\Entity\ConversionEncrypt::initializationVector');
            if($initializationVector === false){
                $ivSize = openssl_cipher_iv_length($this->method);
                $initializationVector = openssl_random_pseudo_bytes($ivSize);
                Session::store('MsPhp\Conversion\Entity\ConversionEncrypt::initializationVector',$initializationVector);
            }
        } else {
            $initializationVector = $this->initializationVector;
        }
        $key = openssl_digest($this->salt, 'sha256');
        $this->result = openssl_encrypt($this->value, $this->method, $key, 0, $initializationVector);
        return $this;
    }
}
