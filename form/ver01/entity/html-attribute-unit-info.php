<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Html\Entity\HtmlDivElement;

class HtmlAttributeUnitInfo extends HtmlDivElement {
    protected $label;
    protected $requirement;
    public function __construct() {
        $this->addClass('in');
    }
    public function setLabel(HtmlAttributeUnitInfoLabel $instance) {
        $this->addChild($instance);
        return $this;
    }
    public function setRequirement(HtmlAttributeUnitInfoRequirement $instance) {
        $this->addChild($instance);
        return $this;
    }
}
