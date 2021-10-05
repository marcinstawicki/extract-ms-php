<?php
namespace MsPhp\Conversion\Entity;

class ConversionSqlDateTime extends Date {

    public function setResult() {
        $format = in_array($this->userCountryCode,$this->exceptionCountriesCodes) ? 'm/d/Y H:i:s' : 'd-m-Y H:i:s';
        if(!is_array($this->value)){
            $this->value = [$this->value];
        }
        foreach($this->value as $key => $isValue){
            if($key === 0) {
                $dateTime = \DateTime::createFromFormat($format,$isValue);
                if($dateTime !== false){
                    $this->result = $dateTime->format('Y-m-d H:i:s');
                }
                break;
            }
        }
        return $this;
    }
}

