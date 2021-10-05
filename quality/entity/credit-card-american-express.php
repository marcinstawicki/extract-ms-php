<?php
namespace MsPhp\Quality\Entity;

class CreditCardAmericanExpress extends RegExp {
    public function __construct(){
        $this->shallValue = '^3[47][0-9]{13}$';
        $this->label = 'American Express credit card format';
    }
}
