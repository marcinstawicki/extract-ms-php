<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Entity\Entity;
use MsPhp\Html\Entity\HtmlInputHiddenElement;


class HtmlInputHidden extends HtmlInputHiddenElement {
    public function __construct() {
        parent::__construct();
        $this->addClass('input-hidden');
    }
    public function setResult() {
        if(Entity::$viewType === Entity::VIEW_TYPE_PROFILE){
            return $this;
        } else {
            return parent::setResult();
        }
    }
}
