<?php
namespace MsPhp\Quality\Entity;

class AccessHuman extends Custom {

    public function setResult(){
        //adjust
        parent::setResult();
        return $this;
    }
}
