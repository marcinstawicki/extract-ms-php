<?php
namespace MsPhp\Quality\Entity;

class IpAddress extends Custom {
    protected $string;

    public function setString($string) {
        $this->string = $string;
        return $this;
    }

    public function setResult() {
        $this->result = filter_var($this->string, FILTER_VALIDATE_IP);
    }
}
