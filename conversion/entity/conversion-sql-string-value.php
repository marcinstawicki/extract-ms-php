<?php
namespace MsPhp\Conversion\Entity;

class ConversionSqlStringValue extends Conversion {

    public function setResult() {
        $this->result = str_replace("'","''",$this->value);
        return $this;
    }
}

