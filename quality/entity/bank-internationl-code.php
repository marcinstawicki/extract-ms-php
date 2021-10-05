<?php
namespace MsPhp\Quality\Entity;

class BankInternationlCode extends RegExp {
    public function __construct(){
        $this->shallValue = '^([a-zA-Z]{4}[a-zA-Z]{2}[a-zA-Z0-9]{2}([a-zA-Z0-9]{3})?)';
        $this->labels[] = 'BIC format';
    }
}
