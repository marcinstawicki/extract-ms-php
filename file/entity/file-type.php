<?php
namespace MsPhp\File\Entity;

class FileType {
    protected $ffmpegPath;
    public function __construct() {
        if(PHP_OS === 'Linux') {
            // ln -s /usr/local/bin/ffmpeg/ffmpeg /usr/bin/ffmpeg
            // then we can access from everywhere
            $this->ffmpegPath = '/usr/local/bin/ffmpeg/ffmpeg';
        } else {
            $this->ffmpegPath = 'C:/ffmpeg/bin/ffmpeg';
        }
    }
}
