<?php

namespace MsPhp\Quality\Entity;

class QualityPasswordStrength extends RegExp {

    public function __construct() {
        $this->shallValue = '(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$';
        $this->labels = [
            'uppercase & lowercase letters',
            'digits',
            'special characters'
        ];
    }
}
