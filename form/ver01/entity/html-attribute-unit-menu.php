<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Entity\Entity;
use MsPhp\Html\Entity\HtmlDivElement;

class HtmlAttributeUnitMenu extends HtmlDivElement {

    public function __construct() {
        $this->addClass('m');
    }
    public function setResult() {
        if(Entity::$viewType === Entity::VIEW_TYPE_PROFILE){
            return $this;
        } else {
            return parent::setResult();
        }
    }
}
