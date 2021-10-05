<?php
namespace MsPhp\Quality\Entity;

class QualityMaxLength extends Quality {

    public function setShallValue($shallValue) {
        $this->labels = ['max. '.$shallValue.' characters'];
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
        return $this;
    }
}
