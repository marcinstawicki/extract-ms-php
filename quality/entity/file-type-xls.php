<?php
namespace MsPhp\Quality\Entity;

class FileTypeXls extends FileType {
    public function __construct(){
        $this->types = array('application/excel', 'application/vnd.ms-excel', 'application/x-excel', 'application/x-msexcel');
        $this->labels[] = '.xls';
    }
}
