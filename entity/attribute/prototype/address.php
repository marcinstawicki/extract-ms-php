<?php
namespace MsPhp\Entity\Attribute\Prototype;

class Address {
    const BUILDING_TYPE_HOUSE = 0;
    const BUILDING_TYPE_BLOCK_OF_FLATS = 1;
    const BUILDING_TYPE_BLOCK_OF_OFFICES = 2;
    //
    protected $street;
    protected $streetNumber;
    protected $building;
    protected $postalCode;
    protected $city;
    protected $region;
    protected $country;

    public function setStreet($streetName) {
        $this->street = $streetName;
        return $this;
    }
    public function setBuilding(Building $instance) {
        $this->buildingName = $instance;
        return $this;
    }
    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
        return $this;
    }
    public function setCity($city) {
        $this->city = $city;
        return $this;
    }
    public function setRegion($region) {
        $this->region = $region;
        return $this;
    }
    public function setCountry(Country $instance) {
        $this->country = $instance;
        return $this;
    }
    //
    public function getStreet() {
        return $this->street;
    }
    public function getBuilding() {
        return $this->building;
    }
    public function getStreetNumber() {
        return $this->streetNumber;
    }
    public function getPostalCode() {
        return $this->postalCode;
    }
    public function getCity() {
        return $this->city;
    }
    public function getRegion() {
        return $this->region;
    }
    public function getCountry() {
        return $this->country;
    }
}
