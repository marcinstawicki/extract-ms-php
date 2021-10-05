<?php

namespace MsPhp\Entity\Attribute;

class ForeignKey {
    protected $name;
    protected $reference;
    const MATCH_SIMPLE = 'SIMPLE';
    protected $match = self::MATCH_SIMPLE;
    const ACTION_CASCADE = 'CASCADE';
    protected $onUpdateAction = self::ACTION_CASCADE;
    protected $onDeleteAction = self::ACTION_CASCADE;

    public function getName(): string {
        return $this->name;
    }
    public function setName(string $name): ForeignKey {
        $this->name = $name;
        return $this;
    }
    public function getReference() {
        return $this->reference;
    }
    public function setReference($attributeInstanceOrArray): ForeignKey {
        $this->reference = $attributeInstanceOrArray;
        return $this;
    }
    public function getMatch(): string {
        return $this->match;
    }
    public function setMatch(string $match): ForeignKey {
        $this->match = $match;
        return $this;
    }
    public function getOnUpdateAction(): string {
        return $this->onUpdateAction;
    }
    public function setOnUpdateAction(string $onUpdateAction): ForeignKey {
        $this->onUpdateAction = $onUpdateAction;
        return $this;
    }
    public function getOnDeleteAction(): string {
        return $this->onDeleteAction;
    }
    public function setOnDeleteAction(string $onDeleteAction): ForeignKey {
        $this->onDeleteAction = $onDeleteAction;
        return $this;
    }
}
