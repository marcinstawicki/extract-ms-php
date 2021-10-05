<?php
namespace MsPhp\Quality\Entity;

class BasicAlphaSpaceSpecial extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_letters.$this->space.$this->basic_latin_special_characters.']+$';
        $this->labels = array(
            $this->basicLettersLabel,
            $this->spaceLabel,
            $this->basicSpecialCharactersLabel
        );
    }
}
