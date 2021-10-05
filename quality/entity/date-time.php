<?php
namespace MsPhp\Quality\Entity;

class DateTime extends Date {
    public function __construct(){
        parent::__construct();
        $labels = array(
            'hour:minute:second',
            'xx:xx:xx',
        );
        $this->labels = array_merge($this->labels,$labels);
    }
}
