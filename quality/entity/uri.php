<?php
namespace MsPhp\Quality\Entity;

class Uri extends Custom {
    protected $string;
    public function setResult() {
        $this->result = filter_var($this->string, FILTER_VALIDATE_URL);
    }
}
