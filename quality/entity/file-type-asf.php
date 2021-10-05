<?php
namespace MsPhp\Quality\Entity;

class FileTypeAsf extends FileType {
    public function __construct(){
        $this->types = array('video/x-ms-asf');
        $this->labels[] = '.asf';
    }
}
