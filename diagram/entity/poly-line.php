<?php
namespace MsPhp\Diagram\Entity;

class PolyLine extends Element {

    public function __construct() {
        $this->variables['points'] = '';
        parent::__construct();
    }

    public function addPoint($x,$y) {
        $this->variables['points'].= $x.' '.$y.' ';
        return $this;
    }
}
