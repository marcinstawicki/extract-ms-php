<?php
namespace MsPhp\Diagram\Entity;

class Svg extends Element {

    public function __construct() {
        $this->variables['groups'] = '';
        $this->variables['viewbox'] = '';
        parent::__construct();
    }

    public function addGroup(Group $object) {
        $this->variables['groups'].= $object->setResult()->getResult();
        return $this;
    }

    public function setHeight($height){
        $this->variables['height'] = $height;
        return $this;
    }

    public function setWidth($width){
        $this->variables['width'] = $width;
        return $this;
    }

    public function setViewBox($offsetLeft,$offsetTop,$width, $height){
        $this->variables['viewbox'] = $offsetLeft.' '.$offsetTop.' '.$width.' '.$height;
        return $this;
    }
}
