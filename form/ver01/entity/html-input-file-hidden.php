<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Entity\Entity;
use MsPhp\Html\Entity\HtmlInputFileElement;

class HtmlInputFileHidden extends HtmlInputFileElement {
    public function __construct() {
        parent::__construct();
        $this->addClass('input-file');
    }
    public function setResult() {
        if(Entity::$viewType === Entity::VIEW_TYPE_PROFILE){
            return $this;
        } else {
            return parent::setResult();
        }
    }
}
