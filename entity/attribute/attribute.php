<?php

namespace MsPhp\Entity\Attribute;

use MsPhp\Conversion\Entity\Conversion;
use MsPhp\Quality\Entity\Quality;

abstract class Attribute {
    protected $name;
    const ID_VALUE_TYPE_SMALLSERIAL = 'smallserial';
    const ID_VALUE_TYPE_SMALLINT = 'smallint';
    const ID_VALUE_TYPE_SERIAL = 'serial';
    const ID_VALUE_TYPE_INT = 'integer';
    const ID_VALUE_TYPE_BIGSERIAL = 'bigserial';
    const ID_VALUE_TYPE_BIGINT = 'bigint';
    protected $idValueType;
    protected $valueType;
    protected $accessType;
    protected $defaultValue;
    protected $isUnique = false;
    protected $isMultiplePrimaryKey = false;
    protected $qualities = [];
    protected $conversionToSql;
    protected $conversionFromSql;
    protected $values = [];
    protected $HtmlElement;
    protected $result;

    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }
    public function setIdValueType(string $valueType) {
        $this->idValueType = $valueType;
        return $this;
    }
    public function setValueType(string $valueType) {
        $this->valueType = $valueType;
        return $this;
    }
    public function setAccessType(string $accessType) {
        $this->accessType = $accessType;
        return $this;
    }
    public function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;
        return $this;
    }
    public function setIsUnique(bool $isUnique) {
        $this->isUnique = $isUnique;
        return $this;
    }
    public function setIsMultiplePrimaryKey(bool $isMultiplePrimaryKey) {
        $this->isMultiplePrimaryKey = $isMultiplePrimaryKey;
        return $this;
    }
    public function addQuality(Quality $instance) {
        $className = get_class($instance);
        $this->qualities[$className] = $instance;
        return $this;
    }
    public function setConversionToSql(Conversion $instance) {
        $this->conversionToSql = $instance;
        return $this;
    }
    public function setConversionFromSql(Conversion $instance) {
        $this->conversionFromSql = $instance;
        return $this;
    }
    public function setValues(array $values) {
        $this->values = $values;
        return $this;
    }
    public function addValue($value) {
        $this->values[] = $value;
        return $this;
    }
    public function setResult() {
        $result = [];
        foreach($this->qualities as $requirement){
            $requirement->setIsValue($this->values)
                ->setResult();
            if($requirement->getResult() === false){
                $result[] = $requirement->getLabels();
            }
        }
        $this->result = empty($result) ? true : $result;
        return $this;
    }

    public function getResult() {
        return $this->result;
    }
    public function getName() {
        return $this->name;
    }
    public function getIdValueType() {
        return $this->idValueType;
    }
    public function getValueType() {
        return $this->valueType;
    }
    public function getAccessType() {
        return $this->accessType;
    }
    public function getDefaultValue() {
        return $this->defaultValue;
    }
    public function getIsUnique(): bool {
        return $this->isUnique;
    }
    public function getIsMultiplePrimaryKey(): bool {
        return $this->isMultiplePrimaryKey;
    }
    public function getQualities(): array {
        return $this->qualities;
    }
    public function getConversionToSql() {
        return $this->conversionToSql;
    }
    public function getConversionFromSql() {
        return $this->conversionFromSql;
    }
    public function getValues() : array {
        return $this->values;
    }
    /**
     * @important: the standard method "clone" does not do its job!
     */
    public function __clone() {
        $vars = get_object_vars($this);
        foreach ($vars as $name => $value) {
            if (is_object($this->$name)) {
                $this->$name = clone $this->$name;
            } else if (is_array($this->$name)) {
                foreach ($this->$name as &$arrayValue) {
                    if (is_object($arrayValue)) {
                        $arrayValue = clone $arrayValue;
                    }
                    unset($arrayValue);
                }
            }
        }
    }
}
