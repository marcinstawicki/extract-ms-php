<?php
namespace MsPhp\Entity\Attribute\Prototype;

class Organisation {
    protected $name;
    protected $establishedOn;
    protected $address;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getEstablishedOn() {
        return $this->establishedOn;
    }

    public function setEstablishedOn($establishedOn) {
        $this->establishedOn = $establishedOn;
        return $this;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress(Address $object) {
        $this->address = $object;
        return $this;
    }

}
