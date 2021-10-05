<?php
namespace MsPhp\Quality\Entity;

class QualityFileTypeTar extends FileType {
    public function __construct(){
        $this->types = ['application/x-tar'];
        $this->labels[] = '.bzip';
    }
}
