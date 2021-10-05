<?php
namespace MsPhp\Quality\Entity;

class TimeDay extends RegExp {
    public function __construct(){
        $this->shallValue = '^[1-31]+$';
        $this->labels = array(
            'day number',
            '01',
            '31'
        );
    }
}
