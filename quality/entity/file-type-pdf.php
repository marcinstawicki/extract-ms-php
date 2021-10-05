<?php
namespace MsPhp\Quality\Entity;

class FileTypePdf extends FileType {
    public function __construct(){
        $this->types = array('application/pdf');
        $this->labels[] = '.pdf';
    }
}
