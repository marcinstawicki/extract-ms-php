<?php
namespace MsPhp\Entity\Attribute\Prototype;

class Phone {
    protected $brandName;
    protected $number;
    protected $setType;

    public function setBrandName(string $brandName) {
        $this->brandName = $brandName;
        return $this;
    }
    public function setNumber(PhoneNumber $number) {
        $this->number = $number;
        return $this;
    }
    public function setSetType($setType) {
        $this->setType = $setType;
        return $this;
    }

    public function getBrandName() {
        return $this->brandName;
    }
    public function getNumber() {
        return $this->number;
    }
    public function getSetType() {
        return $this->setType;
    }
}
