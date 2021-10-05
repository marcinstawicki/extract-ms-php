<?php
namespace MsPhp\VCalendar\Entity;

abstract class VComponent {
    protected $begin;
    protected $end;
    protected $result;

    public function __construct() {
        $parts = explode('\\',get_class($this));
        $className = strtoupper(end($parts));
        $this->begin = $className;
        $this->end = $className;
    }

    public function setResult() {
        $excludes = ['begin','end','result'];
        $result = 'BEGIN:'.$this->begin.PHP_EOL;
        foreach($this as $key => $value){
            if(in_array($key,$excludes) === true) continue;
            if(is_null($value)) continue;
            if($key === 'vComponents'){
                $result.= $value;
            } else {
                $result.= strtoupper($key).':'.$value.PHP_EOL;
            }
        }
        $result.= 'END:'.$this->end.PHP_EOL;
        $this->result = $result;
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}
