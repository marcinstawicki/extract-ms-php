<?php
namespace MsPhp\Quality\Entity;

class QualityMinValue extends Quality {

    public function setShallValue($shallValue) {
        $this->labels = ['min. value: '.$shallValue];
        return parent::setShallValue($shallValue);
    }
    public function setResult(): Quality {
        if(!is_array($this->isValue)){
            $this->isValue = [$this->isValue];
        }
        $result = true;
        foreach($this->isValue as $isValue){
            if($isValue < $this->shallValue){
                $result = false;
            }
        }
        $this->result = $result;
        return $this;
    }

}
