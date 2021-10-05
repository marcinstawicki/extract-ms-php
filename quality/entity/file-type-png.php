<?php
namespace MsPhp\Quality\Entity;

class FileTypePng extends FileType {
    public function __construct(){
        $this->types = array('image/png');
        $this->labels[] = '.png';
    }
}
