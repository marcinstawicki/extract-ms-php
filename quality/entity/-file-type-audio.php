<?php
namespace MS\Quality\Entity;

class FileTypeAudio extends FileType {
    public function __construct(){
        $this->types = [];
        $this->label = 'basic letters (En), space';
    }
}