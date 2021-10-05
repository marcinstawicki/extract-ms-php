<?php
namespace MsPhp\Entity\Attribute\Prototype;

abstract class Property {

    protected $type;

    public function setType(string $type) {
        $this->type = $type;
        return $this;
    }
    public function setIdentifier(string $identifier) {
        $this->identifier = $identifier;
        return $this;
    }
    public function getType() {
        return $this->type;
    }
    public function getIdentifier() {
        return $this->identifier;
    }
}
