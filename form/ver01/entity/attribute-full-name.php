<?php

namespace MsPhp\Form\Ver01\Entity;

class AttributeFullName {
    protected $prefix;
    protected $valueKey;
    protected $attributeName;
    protected $result;
    public function setPrefix(string $prefix) {
        $this->prefix = $prefix;
        return $this;
    }
    public function setAttributeName(string $attributeName) {
        $this->attributeName = $attributeName;
        return $this;
    }
    public function setValueKey(int $valueKey) {
        $this->valueKey = $valueKey;
        return $this;
    }
    public function setResult() {
        $this->result = $this->prefix.'[att]['.$this->attributeName.']['.$this->valueKey.']';
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}
