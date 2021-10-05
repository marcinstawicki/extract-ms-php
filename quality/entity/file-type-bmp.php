<?php
namespace MsPhp\Quality\Entity;

class FileTypeBmp extends FileType {
    public function __construct(){
        $this->types = array('image/bmp', 'image/x-windows-bmp');
        $this->labels[] = '.bmp';
    }
}
