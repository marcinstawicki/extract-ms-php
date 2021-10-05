<?php
namespace MsPhp\Quality\Entity;

class FileTypeSwf extends FileType {
    public function __construct(){
        $this->types = array('application/x-shockwave-flash');
        $this->labels[] = '.swf';
    }
}
