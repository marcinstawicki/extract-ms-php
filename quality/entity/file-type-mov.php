<?php
namespace MsPhp\Quality\Entity;

class FileTypeMov extends FileType {
    public function __construct(){
        $this->types = array('video/quicktime');
        $this->labels[] = '.mov';
    }
}
