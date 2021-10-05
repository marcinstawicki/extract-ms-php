<?php
namespace MsPhp\Quality\Entity;

class ExtendedNumSpecial extends RegExp {
    public function __construct(){
        $this->shallValue = '^['.$this->basic_latin_numbers.$this->basic_latin_special_characters.$this->latin_1_supplement_special_characters.']+$';
        $this->labels = array(
            $this->basicNumbersLabel,
            $this->extendedSpecialCharactersLabel
        );
    }
}
