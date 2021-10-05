<?php
namespace MsPhp\Quality\Entity;

class DomainExistence extends Custom {

    public function __construct() {
        $this->labels = array(
            'the domain has to exist'
        );
    }

    public function setResult($value){
        $this->result = checkdnsrr($value, "MX");
        return $this;
    }
}
