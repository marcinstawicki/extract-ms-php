<?php
namespace MsPhp\Quality\Entity;

class FileTypeCsv extends FileType {
    public function __construct(){
        $this->types = array('text/plain', 'text/csv', 'text/comma-separated-values', 'application/excel', 'application/vnd.ms-excel', 'application/x-excel', 'application/x-msexcel');
        $this->labels[] = '.csv';
    }
}
