<?php
namespace MsPhp\Quality\Entity;

class QualityMaxQuantity extends Quality {

    public function setShallValue($shallValue) {
        $this->labels = ['max. quantity: '.$shallValue];
        return parent::setShallValue($shallValue);
    }
    public function setResult(): Quality {
        if(!is_array($this->isValue)){
            $this->isValue = [$this->isValue];
        }
        $this->result = count($this->isValue) <= $this->shallValue;
        return $this;
    }
}
