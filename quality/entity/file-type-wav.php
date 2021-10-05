<?php
namespace MsPhp\Quality\Entity;

class FileTypeWav extends FileType {
    public function __construct(){
        $this->types = array('audio/wav', 'audio/x-wav');
        $this->labels[] = '.wav';
    }
}
