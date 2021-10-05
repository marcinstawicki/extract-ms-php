<?php
namespace MsPhp\Diagram\Entity;

class Line extends Element {

    public function setX1($x1) {
        $this->variables['x1'] = $x1;
        return $this;
    }

    public function setY1($y1) {
        $this->variables['y1'] = $y1;
        return $this;
    }

    public function setX2($x2) {
        $this->variables['x2'] = $x2;
        return $this;
    }

    public function setY2($y2) {
        $this->variables['y2'] = $y2;
        return $this;
    }
}
