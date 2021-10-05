<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Entity\Entity;
use MsPhp\Html\Entity\HtmlButtonElement;

class HtmlAttributeUnitWorkspaceEditionCollectionElementMenu extends HtmlButtonElement {
    public function __construct() {
        parent::__construct();
        $this->addClass('me');
    }
    public function setResult() {
        if(Entity::$viewType === Entity::VIEW_TYPE_FORM_STAND_ALONE){
            return parent::setResult();
        } else {
            return $this;
        }
    }
}
