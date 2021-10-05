<?php
namespace MsPhp\Quality\Entity;

class FileTypeVideo extends FileType {
    public function __construct(){
        $this->shallValue = '^[' . $this->basic_latin_letters . $this->space . ']+$';
        $this->label = 'basic letters (En), space';
    }
}
