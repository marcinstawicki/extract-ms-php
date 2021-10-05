<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Html\Entity\HtmlDivElement;

class HtmlView extends HtmlDivElement {
    public function __construct() {
        $this->addClass('view');
    }
}
