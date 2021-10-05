<?php
namespace MsPhp\Quality\Process;

use MsPhp\Quality\Entity\Custom;
use MsPhp\Quality\Entity\Database;
use MsPhp\Quality\Entity\FileType;
use MsPhp\Quality\Entity\RegExp;
use MsPhp\Quality\Entity\Quality;

class Verify {
    protected $quality;
    protected $value;
    protected $message;
    protected $result;

    public function setQuality(Quality $instance) {
        $this->quality = $instance;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setResult() {
        if($this->quality instanceof RegExp || $this->quality instanceof FileType || $this->quality instanceof Database || $this->quality instanceof Custom){
            $this->quality->setResult($this->value);
            $result = $this->quality->getResult();
            if($result === false){
                $this->message = $this->quality->getMessage();
            }
        } else {
            $result = null;
        }
        $this->result = $result;
        return $this;
    }

    public function getResult() {
        return $this->result;
    }

    public function getMessage() {
        return $this->message;
    }
}
