<?php
namespace MsPhp\Conversion\Entity;

class ConversionSqlPasswordHash extends Conversion {

    public function setResult() {
        $this->result = password_hash($this->value, PASSWORD_DEFAULT);
        return $this;
    }
}

