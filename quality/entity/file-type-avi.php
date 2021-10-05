<?php
namespace MsPhp\Quality\Entity;

class FileTypeAvi extends FileType {
    public function __construct(){
        $this->types = array('application/x-troff-msvideo', 'video/avi', 'video/msvideo', 'video/x-msvideo');
        $this->labels[] = '.avi';
    }
}
