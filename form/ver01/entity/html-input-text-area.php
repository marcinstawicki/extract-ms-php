<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Entity\Entity;
use MsPhp\Html\Entity\HtmlTextAreaElement;

class HtmlInputTextArea extends HtmlTextAreaElement {
    public function __construct() {
        $this->addClass('input-text');
        if(Entity::$viewType === Entity::VIEW_TYPE_PROFILE){
            $this->setIsReadOnly(true);
        }
    }
}
