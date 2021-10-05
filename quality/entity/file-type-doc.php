<?php
namespace MsPhp\Quality\Entity;

class FileTypeDoc extends FileType {
    public function __construct(){
        $this->types = array('application/msword');
        $this->labels[] = '.doc';
    }
}
