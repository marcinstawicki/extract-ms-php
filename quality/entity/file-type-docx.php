<?php
namespace MsPhp\Quality\Entity;

class FileTypeDocx extends FileType {
    public function __construct(){
        $this->types = array('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $this->labels[] = '.docx';
    }
}
