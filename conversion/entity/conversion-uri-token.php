<?php
namespace MsPhp\Conversion\Entity;

class ConversionUriToken extends Conversion {

    public function setValue($hashOrUserID) {
        $this->value = $hashOrUserID;
        return $this;
    }
    public function setResult() {

        return $this;
    }
}
