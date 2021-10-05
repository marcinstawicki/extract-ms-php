<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\App\Entity\Env;
use MsPhp\App\Entity\UriAdvanced;
use MsPhp\Html\Entity\HtmlInputHiddenElement;
use MsPhp\Html\Entity\HtmlFormElement;

class HtmlViewWorkspace extends HtmlFormElement {
    public function __construct() {
        $this->addClass('vw')
            ->setAction((new UriAdvanced())->setIsSecured())
            ->setMethod(HtmlFormElement::METHOD_POST)
            ->setTarget(HtmlFormElement::TARGET_SELF)
            ->setIsAutoComplete(false)
            ->setIsAutoValidate(false);
        $ph = Env::postHash();
        $input = (new HtmlInputHiddenElement())
            ->setName('s')
            ->setValue($ph);
        $this->addChild($input);
    }
}
