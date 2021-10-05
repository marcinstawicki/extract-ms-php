<?php
namespace MsPhp\Quality\Entity;

class QualityBasicAlpha extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_letters . ']+$';
        $this->labels = [$this->basicLettersLabel];
    }
}
