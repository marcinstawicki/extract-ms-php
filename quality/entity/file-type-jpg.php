<?php
namespace MsPhp\Quality\Entity;

class FileTypeJpg extends FileType {
    public function __construct(){
        $this->types = array('image/jpeg', 'image/pjpeg');
        $this->labels[] = '.jpg';
        $this->labels[] = 'or';
        $this->labels[] = '.jpeg';
    }
}
