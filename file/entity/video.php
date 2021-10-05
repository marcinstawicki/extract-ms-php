<?php

namespace MsPhp\File\Entity;

class Video extends FileType {
    protected $videoFormats = array('flv','mpg','avi','mov','mp4','wmv','swf');
    public function setConvertToMP4($fromPathname,$toPathname){
        $cmd = $this->ffmpegPath.' -i '.$fromPathname.' '.$toPathname;
        shell_exec($cmd);
        return $this;
    }
}
