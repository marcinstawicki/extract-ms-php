<?php
namespace MsPhp\Quality\Entity;

class BasicAlphaNumSpaceSpecial extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_letters.$this->basic_latin_numbers.$this->space.$this->basic_latin_special_characters.']+$';
        $this->labels = array(
            $this->basicLettersLabel,
            $this->basicNumbersLabel,
            $this->spaceLabel,
            $this->basicSpecialCharactersLabel);
    }
}
