<?php
namespace MsPhp\Quality\Entity;

class FileTypeMp4 extends FileType {
    public function __construct(){
        $this->types = array('video/mp4');
        $this->labels[] = '.mp4';
    }
}
