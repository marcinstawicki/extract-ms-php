<?php
namespace MsPhp\Quality\Entity;

class CreditCardVisaMastercard extends RegExp {
    public function __construct(){
        $this->shallValue = '^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14})$';
        $this->label = 'Visa Mastercard credit card format';
    }
}
