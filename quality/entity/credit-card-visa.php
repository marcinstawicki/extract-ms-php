<?php
namespace MsPhp\Quality\Entity;

class CreditCardVisa extends RegExp {
    public function __construct(){
        $this->shallValue = '^4[0-9]{12}(?:[0-9]{3})?$';
        $this->label = 'Visa credit card format';
    }
}
