<?php
namespace MsPhp\App\Entity;

abstract class Entity {
    protected $id;

    public function __construct(){}

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

}
