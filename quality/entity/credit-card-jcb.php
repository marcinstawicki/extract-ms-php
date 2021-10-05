<?php
namespace MsPhp\Quality\Entity;

class CreditCardJcb extends RegExp {
    public function __construct(){
        $this->shallValue = '^(?:2131|1800|35\d{3})\d{11}$';
        $this->label = 'Jcb credit card format';
    }
}
