<?php
namespace MsPhp\Quality\Entity;

class FileTypeGif extends FileType {
    public function __construct(){
        $this->types = array('image/gif');
        $this->labels[] = '.gif';
    }
}
