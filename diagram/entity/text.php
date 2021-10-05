<?php
namespace MsPhp\Diagram\Entity;

class Text extends Element {
    public function setX($x) {
        $this->variables['x'] = $x;
        return $this;
    }
    public function setY($y) {
        $this->variables['y'] = $y;
        return $this;
    }
    public function setDx($dx) {
        $this->variables['dx'] = $dx;
        return $this;
    }
    public function setDy($dy) {
        $this->variables['dy'] = $dy;
        return $this;
    }
    public function setLabel($label) {
        $this->variables['label'] = $label;
        return $this;
    }
}
