<?php
namespace MsPhp\Quality\Entity;

class FileTypeTiff extends FileType {
    public function __construct(){
        $this->types = array('image/tiff', 'image/x-tiff');
        $this->labels[] = '.tif';
        $this->labels[] = 'or';
        $this->labels[] = '.tiff';
    }
}
