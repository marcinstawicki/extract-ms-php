<?php
namespace MsPhp\Quality\Entity;

abstract class Custom extends Quality  {
    protected $isValue;
    protected $shallValue;
    protected $labels = [];
    protected $message;
    protected $result;

    public function setShallValue($value) {
        $this->shallValue = $value;
        return $this;
    }
    public function setIsValue($value) {
        $this->isValue = $value;
        return $this;
    }

    public function setResult() {}

    final public function getResult() {
        return $this->result;
    }

    public function getLabels(): array {
        return $this->labels;
    }
    public function getMessage() {
        return $this->message;
    }
}
