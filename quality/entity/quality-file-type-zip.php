<?php
namespace MsPhp\Quality\Entity;

class QualityFileTypeZip extends FileType {
    public function __construct(){
        $this->types = ['application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip'];
        $this->labels[] = '.zip';
    }
}
