<?php
namespace MsPhp\Quality\Entity;

class CreditCardMastercard extends RegExp {
    public function __construct(){
        $this->shallValue = '^5[1-5][0-9]{14}$';
        $this->label = 'Mastercard credit card format';
    }
}
