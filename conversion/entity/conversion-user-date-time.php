<?php
namespace MsPhp\Conversion\Entity;

class ConversionUserDateTime extends Date {
    public function setResult() {
        $format = in_array($this->userCountryCode,$this->exceptionCountriesCodes) ? 'm/d/Y H:i' : 'd-m-Y H:i';
        $this->result = (new \DateTime($this->value))->format($format);
        return $this;
    }
}
