<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Html\Entity\HtmlButtonElement;
use MsPhp\Html\Entity\TextNode;

class HtmlAttributeUnitMenuTrigger extends HtmlButtonElement {

    const ICON_TYPE_ADD_ONE = 'add-one';
    const ICON_TYPE_REMOVE_ALL = 'remove-all';

    public function __construct() {
        parent::__construct();
        $this->addChild(new TextNode('&nbsp;'));
    }
    public function setIconType($type = self::ICON_TYPE_ADD_ONE) {
        $this->addClass('i_'.$type);
        return $this;
    }
}
