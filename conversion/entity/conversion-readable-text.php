<?php
namespace MsPhp\Conversion\Entity;

class ConversionReadableText extends Conversion {

    public function setResult() {
        $chunks = preg_split('/(?=[A-Z])/', $this->value);
        $string = implode(' ', $chunks);
        $string = str_replace('_', ' ', $string);
        $this->result = trim(strtolower($string));
        return $this;
    }
}
