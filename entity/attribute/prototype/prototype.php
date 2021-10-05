<?php
namespace MsPhp\Entity\Attribute\Prototype;

abstract class Prototype {

    protected ?int $id;

    public function __construct(){}

    public function getID() {
        return $this->id;
    }
    public function setID($id) {
        $this->id = (int) $id;
        return $this;
    }
}
