<?php
namespace MS\Quality\Entity;

class FileTypeImage extends FileType {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_letters . $this->space . ']+$';
        $this->label = 'basic letters (En), space';
    }
}