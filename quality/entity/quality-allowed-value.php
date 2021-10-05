<?php
namespace MsPhp\Quality\Entity;

class QualityAllowedValue extends Quality {

    protected $labelPrefix = 'allowed value(s):';

    public function setShallValue($shallValue) {
        if(!is_array($shallValue)){
            $shallValue = [$shallValue];
        }
        if(empty($this->labels)){
            $this->labels = [$this->labelPrefix.' '.implode(', ',$shallValue)];
        }
        return parent::setShallValue($shallValue);
    }
    public function setResult(): Quality {
        $this->result = in_array($this->isValue,$this->shallValue);
        return $this;
    }
}
