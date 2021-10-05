<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Entity\Entity;
use MsPhp\Html\Entity\HtmlDivElement;

class HtmlAttributeUnitEntityMenu extends HtmlDivElement {

    public function __construct() {
        $this->addClass('me');
    }
    public function setResult() {
        if(Entity::$viewType === Entity::VIEW_TYPE_PROFILE){
            return $this;
        } else {
            return parent::setResult();
        }
    }
}
