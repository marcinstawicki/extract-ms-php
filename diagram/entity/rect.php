<?php
namespace MsPhp\Diagram\Entity;

class Rect extends Element {

    public function setX($x) {
        $this->variables['x'] = $x;
        return $this;
    }

    public function setRx($rx) {
        $this->variables['rx'] = $rx;
        return $this;
    }

    public function setY($y) {
        $this->variables['y'] = $y;
        return $this;
    }

    public function setRy($ry) {
        $this->variables['ry'] = $ry;
        return $this;
    }

    public function setWidth($width) {
        $this->variables['width'] = $width;
        return $this;
    }

    public function setHeight($height) {
        $this->variables['height'] = $height;
        return $this;
    }
}
