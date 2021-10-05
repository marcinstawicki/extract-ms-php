<?php
namespace MsPhp\Quality\Entity;

class QualityTimeHour extends RegExp {

    public function __construct() {
        $this->shallValue = '[1-24]';
        $this->labels = array(
            'hour number',
            '01',
            '24'
        );
    }
}