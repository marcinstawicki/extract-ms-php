<?php
namespace MsPhp\Diagram\Entity;

class Group extends Element {

    public function __construct() {
        $this->variables['elements'] = '';
        parent::__construct();
    }

    public function addElement(Element $object) {
        $this->variables['elements'].= $object->setResult()->getResult();
        return $this;
    }
}
