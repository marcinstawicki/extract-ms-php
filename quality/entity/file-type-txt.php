<?php
namespace MsPhp\Quality\Entity;

class FileTypeTxt extends FileType {
    public function __construct(){
        $this->types = array('text/plain');
        $this->labels[] = '.txt';
    }
}
