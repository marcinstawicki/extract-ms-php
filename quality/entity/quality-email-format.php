<?php
namespace MsPhp\Quality\Entity;

class QualityEmailFormat extends RegExp {
    public function __construct(){
        $this->shallValue = '^[a-zA-Z0-9._%-]+@[a-zA-Z0-9._%-]+\.[a-zA-Z]{2,4}$';
        $this->labels = ['something@domain.com'];
    }
}
