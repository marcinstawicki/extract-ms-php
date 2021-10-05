<?php
namespace MsPhp\Quality\Entity;

class FileTypeFlv extends FileType {
    public function __construct(){
        $this->types = array('video/x-flv');
        $this->labels[] = '.flv';
    }
}
