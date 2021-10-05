<?php
namespace MsPhp\Quality\Entity;

class CreditCardMaestro extends RegExp {
    public function __construct(){
        $this->shallValue = '^(5018|5020|5038|6304|6759|6761|6763)[0-9]{8,15}$';
        $this->label = 'Maestro credit card format';
    }
}
