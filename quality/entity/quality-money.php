<?php
namespace MsPhp\Quality\Entity;

class QualityMoney extends RegExp {
    public function __construct(){
        $this->shallValue = '\'^(((\d{1,3})((,|.)\d{3})*)|(\d+))((,|.)\d+)?$';
        $this->labels = ['digits','xxxx.xx','xxxx,xx'];
    }
}
