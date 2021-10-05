<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Entity\Entity;
use MsPhp\Html\Entity\HtmlDivElement;

class HtmlAttributeUnit extends HtmlDivElement {

    public function __construct() {
        if(Entity::$viewType === Entity::VIEW_TYPE_FORM_PORTABLE){
            $this->addClass('un co');
        } else {
            $this->addClass('un');
        }
    }
}
