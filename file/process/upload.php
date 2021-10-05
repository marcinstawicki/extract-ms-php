<?php
namespace MsPhp\File\Process;

class Upload {

    protected $source;
    protected $destination;
    protected $permission = '0644';
    protected $result;

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
        return $this;
    }

    public function getDestination() {
        return $this->destination;
    }

    public function setDestination($destination) {
        $this->destination = $destination;
        return $this;
    }

    public function getPermission() {
        return $this->permission;
    }

    public function setPermission($permission) {
        $this->permission = $permission;
        return $this;
    }

    public function setResult() {
        $result = @move_uploaded_file($this->source, $this->destination);
        if ($result === true) {
            chmod($this->destination, $this->permission);
        }
        $this->result = $result;
        return $this;
    }

    public function getResult() {
        return $this->result;
    }
}
