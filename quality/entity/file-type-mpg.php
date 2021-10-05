<?php
namespace MsPhp\Quality\Entity;

class FileTypeMpg extends FileType {
    public function __construct(){
        $this->types = array('video/mpeg');
        $this->labels[] = '.mpg';
        $this->labels[] = '.mpe';
        $this->labels[] = '.mpeg';
    }
}
