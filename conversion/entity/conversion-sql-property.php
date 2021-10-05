<?php
namespace MsPhp\Conversion\Entity;

class ConversionSqlProperty extends Conversion {

    public function setResult() {
        $chunks = preg_split('/(?=[A-Z])/', $this->value);
        $string = implode('_', $chunks);
        $this->result = trim(strtolower($string),'_');
        return $this;
    }
}
