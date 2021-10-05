<?php
namespace MsPhp\Entity\Attribute\Prototype;

class Building extends Property {
    const TYPE_HOUSE = 'house';
    const TYPE_BLOCK_OF_FLATS = 'block of flats';
    const TYPE_BLOCK_OF_OFFICES = 'block of offices';
    protected $units;

    public function addUnit(Unit $instance) {
        $this->units[] = $instance;
        return $this;
    }
    public function getUnits() {
        return $this->units;
    }
}
