<?php

namespace MsPhp\Entity\Attribute;

class Reference {
    protected $entity;
    protected $attribute;
    public function setEntity(Entity $instance) {
        $this->entity = $instance;
        return $this;
    }
    public function setAttribute(Attribute $instance) {
        $this->attribute = $instance;
        return $this;
    }
    public function getEntity() : Entity {
        return $this->entity;
    }
    public function getAttribute(): Attribute {
        return $this->attribute;
    }
}
