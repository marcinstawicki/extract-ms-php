<?php
namespace MsPhp\Entity\Attribute\Prototype;

abstract class PhoneNumber {
    protected $internationalDiallingCode;
    protected $mainNumber;

    public function setInternationalDiallingCode(string $internationalDiallingCode) {
        $this->internationalDiallingCode = $internationalDiallingCode;
        return $this;
    }
    public function setMainNumber(string $mainNumber) {
        $this->mainNumber = $mainNumber;
        return $this;
    }
    public function getInternationalDiallingCode() : string {
        return $this->internationalDiallingCode;
    }
    public function getMainNumber() : string {
        return $this->mainNumber;
    }

}
