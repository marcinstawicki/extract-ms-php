<?php
namespace MsPhp\Quality\Entity;

class ExtendedAlphaSpace extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_letters . $this->latin_1_supplement_letters . $this->latin_extended_a . $this->latin_extended_b . $this->cyrillic . $this->cyrillic_supplement . $this->space.']+$';
        $this->labels = array(
            $this->extendedLettersLabel,
            $this->spaceLabel
        );
    }
}
