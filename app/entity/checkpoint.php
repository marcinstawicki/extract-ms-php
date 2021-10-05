<?php
namespace MsPhp\App\Entity;

class Checkpoint {
    protected $id;
    protected $pathname;
    protected $roles = [];

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getPathname() {
        return $this->parameter;
    }
    public function setPathname($pathname) {
        $this->pathname = $pathname;
        return $this;
    }
    public function getRoles() {
        return $this->roles;
    }
    public function setRoles(array $roles) {
        $this->roles = $roles;
        return $this;
    }
}
