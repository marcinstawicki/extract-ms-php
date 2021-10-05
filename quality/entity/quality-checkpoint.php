<?php
namespace MsPhp\Quality\Entity;

class QualityCheckpoint extends Quality {

    public function setResult(): Quality {
        if(!is_array($this->shallValue)){
            $this->shallValue = [$this->shallValue];
        }
        if(!is_array($this->isValue)){
            $this->isValue = [$this->isValue];
        }
        $result = array_intersect($this->shallValue,$this->isValue);
        $this->result = empty($result) ? false : true;
        return $this;
    }
}
