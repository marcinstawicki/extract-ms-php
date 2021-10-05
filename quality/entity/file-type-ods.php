<?php
namespace MsPhp\Quality\Entity;

class FileTypeOds extends FileType {
    public function __construct(){
        $this->types = array('application/vnd.oasis.opendocument.spreadsheet', 'application/x-vnd.oasis.opendocument.spreadsheet');
        $this->labels[] = '.ods';
    }
}
