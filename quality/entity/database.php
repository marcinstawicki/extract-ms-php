<?php
namespace MsPhp\Quality\Entity;

use MsPhp\App\Entity\Resource;
use MsPhp\App\Entity\PhraseBook;

abstract class Database extends Quality {

    protected $database;
    protected $labels;
    protected $result = false;
    public function __construct() {
        $this->database = (Resource::getInstance())->getDatabase();
    }

    public function getLabels() {
        return $this->labels;
    }

    public function setResult($value) {
        return $this;
    }

    public function getResult() {
        return $this->result;
    }
}
