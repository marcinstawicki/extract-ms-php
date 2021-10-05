<?php
namespace MsPhp\Quality\Entity;

class QualityHttpAcceptedLanguage extends Custom {

    public function setResult(){
        $this->result = !empty($this->isValue);
        return $this;
    }
}
