<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Html\Entity\TextNode;

class HtmlFormAutocompleteForget extends HtmlFormAutocomplete {
    public function __construct() {
        parent::__construct();
        $this->addClass('af')
            ->addChild(new TextNode('auto-forget'));
    }
}
