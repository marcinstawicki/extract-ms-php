<?php

namespace MsPhp\Css\Entity;

abstract class SubStyle {
    protected $result;

    public function setResult() {
        $properties = get_object_vars($this);
        unset($properties['result']);
        $parts = explode('\\',get_class($this));
        $last = end($parts);
        $classN = strtolower($last);
        foreach ($properties as $property => $value) {
            if(!empty($value)) {
                $property =  strtolower(preg_replace('/([a-z])([A-Z])/', '\1-\2', $property));
                $this->result .= $classN.'-'.$property.':'.$value.';';
            }
        }
        return $this;
    }

    public function getResult() {
        return $this->result;
    }
}
