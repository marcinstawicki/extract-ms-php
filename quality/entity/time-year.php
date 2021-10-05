<?php
namespace MsPhp\Quality\Entity;

class Year extends RegExp {
    public function __construct(){
        $this->shallValue = '^(19[0-9][0-9]|20[0-9][0-9])$';
        $this->labels = array(
            '4 digits',
            '1900',
            '2000'
        );
    }
}
