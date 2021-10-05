<?php

namespace MsPhp\Css\Entity;

class Style {
    protected $font;
    protected $background;
    protected $border;
    protected $text;
    protected $display = false;
    protected $width;
    protected $minWidth;
    protected $maxWidth;
    protected $textAlign;
    protected $result;

    public function setFont(Font $instance) {
        $this->font = $instance;
        return $this;
    }
    public function setBackground(Background $instance) {
        $this->background = $instance;
        return $this;
    }
    public function setBorder(Border $instance) {
        $this->border = $instance;
        return $this;
    }
    public function setText(Text $instance) {
        $this->text = $instance;
        return $this;
    }
    public function setDisplay($display) {
        $this->display = $display;
        return $this;
    }
    public function setWidth($width) {
        $this->width = is_numeric($width) ? $width.'px' : $width;
        return $this;
    }
    public function setMinWidth($minWidth) {
        $this->minWidth = is_numeric($minWidth) ? $minWidth.'px' : $minWidth;
        return $this;
    }
    public function setMaxWidth($maxWidth) {
        $this->maxWidth = is_numeric($maxWidth) ? $maxWidth.'px' : $maxWidth;
        return $this;
    }
    public function setTextAlign($textAlign) {
        $this->textAlign = $textAlign;
        return $this;
    }
    public function setResult() {
        $properties = get_object_vars($this);
        unset($properties['result']);
        foreach ($properties as $property => $value) {
            if($value instanceof SubStyle){
                $this->result .= $value->setResult()->getResult();
            } else if(!empty($value)) {
                $property =  strtolower(preg_replace('/([a-z])([A-Z])/', '\1-\2', $property));
                $this->result .= $property.':'.$value.';';
            }
        }
        return $this;
    }

    public function getResult() {
        return $this->result;
    }

}
