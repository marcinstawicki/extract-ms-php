<?php
namespace MsPhp\Conversion\Entity;

abstract class Conversion {

    protected $result;
    protected $value;

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
    public function setResult() {
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}
