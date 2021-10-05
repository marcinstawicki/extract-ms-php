<?php
namespace MsPhp\Quality\Entity;

class QualityEmailExistence extends Quality {

    public function __construct() {
        $this->labels = ['the email has to exist'];
    }
    public function setResult(){
        list($prefix,$domain) = explode('@',$this->isValue);
        $this->result = checkdnsrr($domain, "MX");
        return $this;
    }
}
