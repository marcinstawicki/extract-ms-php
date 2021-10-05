<?php
namespace MsPhp\Conversion\Entity;

class ConversionUnderscore extends Conversion {
    protected $string;

    public function setString(string $string) {
        $this->string = $string;
        return $this;
    }
    public function setResult() {
        $string = preg_replace('/\s+/','_',$this->string);
        $string = str_replace(array('\\'),array('_'),$string);
        $chunks = preg_split('/(?=[A-Z])/', $string);
        $string = trim(implode('_', $chunks),'_');
        $this->result = mb_strtolower($string);
        return $this;
    }
}
