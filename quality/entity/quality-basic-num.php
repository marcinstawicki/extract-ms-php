<?php
namespace MsPhp\Quality\Entity;

class QualityBasicNum extends RegExp {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_numbers.']+$';
        $this->labels = [$this->basicNumbersLabel];
    }
}
