<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Html\Entity\HtmlDivElement;

class HtmlViewInfo extends HtmlDivElement {
    public function __construct() {
        $this->addClass('view-info');
    }
}
