<?php
namespace MsPhp\Quality\Entity;

class Month extends RegExp {
    public function __construct(){
        $this->shallValue = '^[1-12]+$';
        $this->labels = array(
            'month number',
            '01',
            '12'
        );
    }
}
