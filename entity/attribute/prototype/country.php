<?php
namespace MsPhp\Entity\Attribute\Prototype;

class Country extends Prototype {
    protected $alpha2;
    protected $alpha3;
    protected $code;
    protected $iso;
    protected $name;
    protected $region;
    protected $regionCode;
    protected $subregion;
    protected $subregionCode;
    protected $timezoneTypes = [];

    public function setAlpha2(string $alpha2) {
        $this->alpha2 = $alpha2;
        return $this;
    }
    public function setAlpha3(string $alpha3) {
        $this->alpha3 = $alpha3;
        return $this;
    }
    public function setCode(string $code) {
        $this->code = $code;
        return $this;
    }
    public function setIso(string $iso) {
        $this->iso = $iso;
        return $this;
    }
    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }
    public function setRegion(string $region) {
        $this->region = $region;
        return $this;
    }
    public function setRegionCode(string $regionCode) {
        $this->regionCode = $regionCode;
        return $this;
    }
    public function setSubregion(string $subregion) {
        $this->subregion = $subregion;
        return $this;
    }
    public function setSubregionCode(string $subregionCode) {
        $this->subregionCode = $subregionCode;
        return $this;
    }
    public function addTimezoneType(string $timezoneType) {
        $this->timezoneTypes[] = $timezoneType;
        return $this;
    }
    //
    public function getAlpha2() {
        return $this->alpha2;
    }
    public function getAlpha3() {
        return $this->alpha3;
    }
    public function getCode() {
        return $this->code;
    }
    public function getIso() {
        return $this->iso;
    }
    public function getName() {
        return $this->name;
    }
    public function getRegion() {
        return $this->region;
    }
    public function getRegionCode() {
        return $this->regionCode;
    }
    public function getSubregion() {
        return $this->subregion;
    }
    public function getSubregionCode() {
        return $this->subregionCode;
    }
    public function getTimezoneTypes(): array {
        return $this->timezoneTypes;
    }
}
