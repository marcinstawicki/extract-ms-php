<?php

namespace MsPhp\Form\Ver01\Entity;

class EntityIdFullName {
    protected $prefix;
    protected $result;
    public function setPrefix(string $prefix) {
        $this->prefix = $prefix;
        return $this;
    }
    public function setResult() {
        $this->result = $this->prefix.'[id]';
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}
