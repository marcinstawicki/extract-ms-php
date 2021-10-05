<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Entity\Entity;
use MsPhp\Html\Entity\HtmlAttribute;
use MsPhp\Html\Entity\HtmlButtonElement;
use MsPhp\Html\Entity\TextNode;

class HtmlAttributeUnitWorkspaceTrigger extends HtmlButtonElement {

    const ICON_TYPE_SELECT = 'select';
    const ICON_TYPE_SELECT_MULTISTAGE = 'select-multistage';
    const ICON_TYPE_TEXT = 'text';
    const ICON_TYPE_TEXT_SUGGEST = 'text-suggest';
    const ICON_TYPE_FILE = 'file';
    const ICON_TYPE_DATE = 'date';
    const ICON_TYPE_TIME = 'time';
    const ICON_TYPE_TIMESTAMP = 'timestamp';
    const ICON_TYPE_PASSWORD = 'password';

    public function __construct() {
        parent::__construct();
        $this->addClass('a1')
            ->addClass('s0')
            ->addChild(new TextNode('&nbsp;'));
    }
    public function setIconType($type = self::ICON_TYPE_TEXT) {
        $this->addClass('t_'.$type);
        return $this;
    }
    public function setResult() {
        if(Entity::$viewType === Entity::VIEW_TYPE_PROFILE){
            return $this;
        } else {
            return parent::setResult();
        }
    }
}
