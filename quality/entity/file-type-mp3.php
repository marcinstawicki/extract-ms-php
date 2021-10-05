<?php
namespace MsPhp\Quality\Entity;

class FileTypeMp3 extends FileType {
    public function __construct(){
        $this->types = array('audio/mpeg', 'audio/mpeg3', 'audio/x-mpeg3');
        $this->labels[] = '.mp3';
    }
}
