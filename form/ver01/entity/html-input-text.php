<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Entity\Entity;
use MsPhp\Html\Entity\HtmlInputTextElement;

class HtmlInputText extends HtmlInputTextElement {
    public function __construct() {
        parent::__construct();
        $this->addClass('input-text');
        if(Entity::$viewType === Entity::VIEW_TYPE_PROFILE){
            $this->setIsReadOnly(true);
        }
    }
}
