<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Html\Entity\HtmlDivElement;

class HtmlAttributeUnitWorkspaceEditionSearch extends HtmlDivElement {

    public function __construct() {
        $this->addClass('search')
            ->setA(0)
            ->setContentEditable(true);
    }
}
