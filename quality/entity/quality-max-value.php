<?php
namespace MsPhp\Quality\Entity;

class QualityMaxValue extends Quality {

    public function setShallValue($shallValue) {
        $this->labels = ['max. value: '.$shallValue];
        return parent::setShallValue($shallValue);
    }
    public function setResult(): Quality {
        if(!is_array($this->isValue)){
            $this->isValue = [$this->isValue];
        }
        $result = true;
        foreach($this->isValue as $isValue){
            if(mb_strlen($isValue) > $this->shallValue){
                $result = false;
            }
        }
        $this->result = $result;
        $this->result = $this->isValue <= $this->shallValue;
        return $this;
    }
}
