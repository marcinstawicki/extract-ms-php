<?php
namespace MsPhp\Entity\Attribute\Prototype;

class LandlinePhoneNumber extends MobilePhoneNumber {
    protected $diallingCode;
    public function setDiallingCode(string $diallingCode) {
        $this->diallingCode = $diallingCode;
        return $this;
    }
    public function getDiallingCode() : string {
        return $this->diallingCode;
    }
}
