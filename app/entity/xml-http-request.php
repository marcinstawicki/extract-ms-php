<?php
namespace MsPhp\App\Entity;


class XmlHttpRequest {
    protected $result = false;
    public function setResult(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
            $this->result = true;
        }
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}
