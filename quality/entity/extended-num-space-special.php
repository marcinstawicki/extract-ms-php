<?php
namespace MsPhp\Quality\Entity;

class ExtendedNumSpaceSpecial extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' .$this->basic_latin_numbers .$this->space. $this->basic_latin_special_characters.$this->latin_1_supplement_special_characters.']+$';
        $this->labels = array(
            $this->basicNumbersLabel,
            $this->spaceLabel,
            $this->extendedSpecialCharactersLabel
        );
    }
}
