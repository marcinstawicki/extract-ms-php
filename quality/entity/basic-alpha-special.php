<?php
namespace MsPhp\Quality\Entity;

class BasicAlphaSpecial extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_letters.$this->basic_latin_special_characters.']+$';
        $this->labels = array(
            $this->basicLettersLabel,
            $this->basicSpecialCharactersLabel
        );
    }
}
