<?php
namespace MsPhp\Quality\Entity;

class AccessEntry extends Custom {

    public function setResult(){
        //adjust
        parent::setResult();
        return $this;
    }
}
