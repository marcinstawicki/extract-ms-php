<?php
namespace MsPhp\File\Entity;

class Audio extends FileType {
    protected $audioFormats = array('ogg','wma','wav','mp3','mp4','wmv');
    public function setConvertToMP3($fromPathname,$toPathname){
        $cmd = $this->ffmpegPath.' -i '.$fromPathname.' '.$toPathname;
        shell_exec($cmd);
        return $this;
    }
}
