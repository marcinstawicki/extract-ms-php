<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Html\Entity\HtmlButtonElement;
use MsPhp\Html\Entity\TextNode;

class HtmlAttributeUnitEntityMenuTrigger extends HtmlButtonElement {

    const ICON_TYPE_ADD_ONE_IN_FRONT = 'add-one-in-front';
    const ICON_TYPE_ADD_ONE_BEHIND = 'add-one-in-front';
    const ICON_TYPE_REMOVE = 'remove';
    const ICON_TYPE_MOVE_UP = 'move-up';
    const ICON_TYPE_MOVE_DOWN = 'move-down';

    public function __construct() {
        parent::__construct();
            $this->addChild(new TextNode('&nbsp;'));
    }
    public function setIconType($type = self::ICON_TYPE_ADD_ONE_IN_FRONT) {
        $this->addClass('i_'.$type);
        return $this;
    }
}
