<?php
namespace MsPhp\Quality\Entity;

class QualityFileTypeBzip extends FileType {
    public function __construct(){
        $this->types = ['application/x-bzip', 'application/x-bzip2'];
        $this->labels[] = '.bzip';
    }
}
