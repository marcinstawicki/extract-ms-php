<?php
namespace MsPhp\Quality\Entity;

class QualityFileTypeSh extends FileType {
    public function __construct(){
        $this->types = ['application/x-bsh', 'application/x-sh', 'application/x-shar', 'text/x-script.sh'];
        $this->labels[] = '.sh';
    }
}
