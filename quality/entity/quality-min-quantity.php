<?php
namespace MsPhp\Quality\Entity;

class QualityMinQuantity extends Quality {

    public function setShallValue($shallValue) {
        $this->labels = ['min. quantity: '.$shallValue];
        parent::setShallValue($shallValue);
        return $this;
    }
    public function setResult() {
        if(!is_array($this->isValue)){
            $this->isValue = [$this->isValue];
        }
        $this->result = count($this->isValue) >= $this->shallValue;
        return $this;
    }
}
