<?php

namespace MsPhp\Form\Ver01\Entity;


class HtmlFormSubmitStore extends HtmlFormSubmit {
    public function __construct() {
        parent::__construct();
        $this->addClass('su')
            ->setName('submit')
            ->setValue('submit');
    }
}
