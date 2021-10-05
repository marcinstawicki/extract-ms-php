<?php
namespace MsPhp\Quality\Entity;

class CreditCardDinersClub extends RegExp {
    public function __construct(){
        $this->shallValue = '^3(?:0[0-5]|[68][0-9])[0-9]{11}$';
        $this->label = 'Diners Club credit card format';
    }
}
