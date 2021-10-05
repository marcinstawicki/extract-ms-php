<?php
namespace MsPhp\Quality\Entity;

class Time extends Date {
    public function __construct(){
        $this->labels = array(
            'hour:minute:second',
            'xx:xx:xx',
        );
    }
    public function setResult() {
        try {
            $date = new \DateTime();
            $this->result = (bool) new \DateTime($date->format('Y-m-d').' '.$this->string);
        } catch (\Exception $e){
            $this->result = false;
        }
    }
}
