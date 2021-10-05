<?php

namespace MsPhp\Entity\Attribute;

class AttributeNumericType extends Attribute {
    const VALUE_TYPE_MONEY = 'money';
    const VALUE_TYPE_DECIMAL_NUMERIC = 'decimal';
    const VALUE_TYPE_REAL = 'real';
    const VALUE_TYPE_DOUBLE_PRECISION = 'double precision';
    const VALUE_TYPE_SMALLINT = 'smallint';
    const VALUE_TYPE_INT = 'integer';
    const VALUE_TYPE_BIGINT = 'bigint';
    protected $foreignKey;
    protected $children = [];


    public function setForeignKey(ForeignKey $instance) {
        $this->foreignKey = $instance;
        return $this;
    }
    public function getForeignKey() {
        return $this->foreignKey;
    }
    public function getChildren() {
        return $this->children;
    }
    public function addChild(Entity $instance) {
        $this->children[] = $instance;
        return $this;
    }
    public function unsetChildren() {
        $this->children = [];
        return $this;
    }
}
