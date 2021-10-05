<?php
namespace MsPhp\Quality\Entity;

class BasicAlphaSpace extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_letters . $this->space . ']+$';
        $this->labels = array(
            $this->basicLettersLabel,
            $this->spaceLabel
        );
    }
}
