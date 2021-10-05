<?php
namespace MsPhp\Quality\Entity;

abstract class Quality {
    protected $isValue;
    protected $shallValue;
    protected $labels = [];
    protected $message;
    protected $labelPrefix = '';
    protected $result;
    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PROTECTED = 'protected';
    const VISIBILITY_PRIVATE = 'private';
    protected $visibility = self::VISIBILITY_PUBLIC;
    
    public function setLabels(array $labels)
    {
        $this->labels = $labels;
        return $this;
    }

    public function setLabelPrefix(string $labelPrefix)
    {
        $this->labelPrefix = $labelPrefix;
        return $this;
    }

    public function setVisibility(string $visibility)
    {
        $this->visibility = $visibility;
        return $this;
    }

    public function setShallValue($value) {
        $this->shallValue = $value;
        return $this;
    }
    public function setIsValue($value) {
        $this->isValue = $value;
        return $this;
    }

    public function setResult() {}
    public function getResult() {
        return $this->result;
    }

    public function getLabels(): array {
        return $this->labels;
    }
    public function getMessage() {
        return $this->message;
    }
    public function getIsValue() {
        return $this->isValue;
    }
    public function getShallValue() {
        return $this->shallValue;
    }
}
