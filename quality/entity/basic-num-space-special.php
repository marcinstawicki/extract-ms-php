<?php
namespace MsPhp\Quality\Entity;

class BasicNumSpaceSpecial extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_numbers.$this->space.$this->basic_latin_special_characters.']+$';
        $this->label = 'digits, space, basic special characters (En)';
        $this->labels = array(
            $this->basicNumbersLabel,
            $this->spaceLabel,
            $this->basicSpecialCharactersLabel
        );
    }
}
