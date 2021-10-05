<?php
namespace MsPhp\Quality\Entity;

class FileTypeOdt extends FileType {
    public function __construct(){
        $this->types = array('application/vnd.oasis.opendocument.text', 'application/x-vnd.oasis.opendocument.text');
        $this->labels[] = '.odt';
    }
}
