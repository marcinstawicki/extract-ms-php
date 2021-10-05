<?php
namespace MsPhp\Quality\Entity;

class FileTypeWmv extends FileType {
    public function __construct(){
        $this->types = array('video/x-ms-wmv');
        $this->labels[] = '.wmv';
    }
}
