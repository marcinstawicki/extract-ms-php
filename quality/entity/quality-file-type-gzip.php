<?php
namespace MsPhp\Quality\Entity;

class QualityFileTypeGzip extends FileType {
    public function __construct(){
        $this->types = ['application/x-gzip', 'multipart/x-gzip'];
        $this->labels[] = '.gzip';
    }
}
