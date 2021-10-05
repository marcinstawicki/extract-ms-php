<?php
namespace MsPhp\Quality\Entity;

class BasicAlphaNum extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_letters.$this->basic_latin_numbers.']+$';
        $this->labels = array(
            $this->basicLettersLabel,
            $this->basicNumbersLabel
        );
    }
}
