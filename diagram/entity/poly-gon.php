<?php
namespace MsPhp\Diagram\Entity;

class PolyGon extends Element {
    protected $points = [];

    public function getPoints() {
        return $this->points;
    }

    public function setPoints(array $points) {
        $this->points = $points;
        return $this;
    }

    public function setResult() {
        $this->variables = [];
        parent::setResult();
        return $this;
    }
}
