<?php
namespace MsPhp\Quality\Entity;

class BasicNumSpace extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_numbers.$this->space.']+$';
        $this->label = 'digits, space';
        $this->labels = array(
            $this->basicNumbersLabel,
            $this->spaceLabel
        );
    }
}
