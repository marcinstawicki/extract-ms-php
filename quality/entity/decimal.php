<?php
namespace MsPhp\Quality\Entity;

class Decimal extends RegExp {
    public function __construct(){
        $this->shallValue = '^-?(([1-9]\d*)|0)(.0*[1-9](0*[1-9])*)?$';
        $this->labels = array(
            $this->basicNumbersLabel.'.'.$this->basicNumbersLabel,
            'xx.xx'
        );
    }
}
