<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Html\Entity\TextNode;

class HtmlFormAutocompleteRemember extends HtmlFormAutocomplete {
    public function __construct() {
        parent::__construct();
        $this->addClass('ar')
            ->addChild(new TextNode('auto-remember'));
    }
}
