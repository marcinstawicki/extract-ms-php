<?php
namespace MsPhp\Conversion\Entity;

class ConversionCamelCase extends Conversion {

    protected $mode;
    const MODE_AS_IS = 'as is';
    const MODE_JOIN_WORDS = 'join';

    public function setMode($mode = self::MODE_AS_IS) {
        $this->mode = $mode;
        return $this;
    }
    public function setResult() {
        $from = array('_','-','/');
        $to = array(' ',' ',' \ ');
        $string = str_replace($from,$to, trim(strtolower($this->value)));
        $string = ucwords($string);
        $string = str_replace(' \ ','\\', $string);
        if($this->mode === self::MODE_JOIN_WORDS){
            $string = preg_replace('/\s+/','',$string);
        }
        $this->result = $string;
        return $this;
    }
}
