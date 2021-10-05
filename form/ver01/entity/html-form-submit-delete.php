<?php

namespace MsPhp\Form\Ver01\Entity;


class HtmlFormSubmitDelete extends HtmlFormSubmit {
    public function __construct() {
        parent::__construct();
        $this->addClass('de')
            ->setName('submit')
            ->setValue('delete');
    }
}
