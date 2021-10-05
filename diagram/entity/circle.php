<?php
namespace MsPhp\Diagram\Entity;

class Circle extends Element {

    public function setCx($cx) {
        $this->variables['cx'] = $cx;
        return $this;
    }

    public function setCy($cy) {
        $this->variables['cy'] = $cy;
        return $this;
    }

    public function setR($r) {
        $this->variables['r'] = $r;
        return $this;
    }
}
