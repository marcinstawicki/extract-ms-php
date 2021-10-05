<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Html\Entity\TextNode;

class HtmlFormAutocompleteApply extends HtmlFormAutocomplete {
    public function __construct() {
        parent::__construct();
        $this->addClass('aa')
            ->addChild(new TextNode('auto-apply'));
    }
}
