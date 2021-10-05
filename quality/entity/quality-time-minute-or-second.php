<?php
namespace MsPhp\Quality\Entity;

class QualityTimeMinuteOrSecond extends RegExp {
    public function __construct(){
        $this->shallValue = '^[1-59]+$';
        $this->labels[] = 'digits between 1 and 59';
    }
}
