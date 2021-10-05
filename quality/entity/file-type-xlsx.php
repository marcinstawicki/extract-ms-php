<?php
namespace MsPhp\Quality\Entity;

class FileTypeXlsx extends FileType {
    public function __construct(){
        $this->types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $this->labels[] = '.xlsx';
    }
}
