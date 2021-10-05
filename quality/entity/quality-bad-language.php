<?php
namespace MsPhp\Quality\Entity;

class QualityBadLanguage extends RegExp {
    public function __construct(){
        $this->shallValue = '^[(fuck|blowjob|cumshot)]+$';
        $this->labels = array('no bad language!');
    }
}
