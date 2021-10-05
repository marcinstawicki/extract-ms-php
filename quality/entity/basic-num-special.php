<?php
namespace MsPhp\Quality\Entity;

class BasicNumSpecial extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_numbers.$this->basic_latin_special_characters.']+$';
        $this->labels = array(
            $this->basicNumbersLabel,
            $this->spaceLabel,
            $this->basicSpecialCharactersLabel
        );
    }
}
