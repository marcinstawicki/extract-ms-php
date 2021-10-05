<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\Html\Entity\HtmlInputTextElement;
use MsPhp\Html\Entity\TextNode;

class HtmlFormReset extends HtmlInputTextElement {
    public function __construct() {
        parent::__construct();
        $this->addClass('re')
            ->setName('reset')
            ->setValue('reset');
    }
}
