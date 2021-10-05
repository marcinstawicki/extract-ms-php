<?php
namespace MsPhp\Conversion\Entity;

class ConversionHyphen extends Conversion {
    protected $string;

    public function setString(string $string) {
        $this->string = $string;
        return $this;
    }
    public function setResult() {
        $string = preg_replace('/\s+/','-',$this->string);
        $string = str_replace(array('_','\\'),array('-',' \ '),$string);
        $chunks = preg_split('/(?=[A-Z])/', $string);
        $string = trim(implode('-', $chunks),'-');
        $string = str_replace(array(' \ ','/-'),array('/','/'), $string);
        $this->result = strtolower($string);
        return $this;
    }
}
