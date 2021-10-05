<?php
namespace MsPhp\Conversion\Entity;

class ConversionUserDecimal extends Decimal {
    public function setResult() {
        $decimalMark = in_array($this->userCountryCode,$this->exceptionCountriesCodes) ? '.' : ',';
        $this->result = str_replace('.',$decimalMark,$this->value);
        return $this;
    }
}
