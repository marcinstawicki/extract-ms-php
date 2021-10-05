<?php
namespace MsPhp\Quality\Entity;

class FileTypeRam extends FileType {
    public function __construct(){
        $this->types = array('audio/x-pn-realaudio');
        $this->labels[] = '.ram';
    }
}
