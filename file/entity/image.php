<?php
namespace MsPhp\File\Entity;

class Image extends FileType {

    private $fileName;
    private $file;
    private $type;
    private $iniWidth;
    private $iniHeight;
    private $iniRatio;
    private $width;
    private $height;

    public function __construct($fileName) {
        parent::__construct();
        $this->fileName = $fileName;
        if (file_exists($fileName)) {
            list($this->iniWidth, $this->iniHeight, $this->type) = getimagesize($fileName);
            switch ($this->type) {
                case IMAGETYPE_GIF:
                    $file = imagecreatefromgif($fileName);
                    break;
                case IMAGETYPE_JPEG:
                    $file = imagecreatefromjpeg($fileName);
                    break;
                case IMAGETYPE_PNG:
                    $file = imagecreatefrompng($fileName);
                    break;
                default:
                    $file = null;
                    break;
            }
            $this->iniRatio = $this->iniWidth / $this->iniHeight;
            $this->file = $file;
        } else {
            die();
        }
    }

    public function setWidth($width) {
        $this->width = (int) $width;
        return $this;
    }
    public function setHeight($height) {
        $this->height = (int) $height;
        return $this;
    }
    public function setScaleToMax() {
        if (!is_null($this->height)) {
            $finalHeight = $this->height;
            $finalWidth = ceil($this->height * $this->iniRatio);
        } else if (!is_null($this->width)) {
            $finalHeight = ceil($this->width / $this->iniRatio);
            $finalWidth = $this->width;
        } else {
            die();
        }
        $holder = imagecreatetruecolor($finalWidth,$finalHeight);
        imagecopyresampled($holder, $this->file, 0, 0, 0, 0, $finalWidth, $finalHeight, $this->iniWidth, $this->iniHeight);
        switch ($this->type) {
            case IMAGETYPE_GIF:
                imagegif($holder, $this->fileName);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($holder, $this->fileName);
                break;
            case IMAGETYPE_PNG:
                imagepng($holder, $this->fileName);
                break;
            default:
                break;
        }
        imagedestroy($this->file);
        return $this;
    }
    public function setScaleToMaxWidth(){
        /**
         * under Windows there is a problem with shell_exec which gives only null back.
         */
        $pathnameParts = explode('/',$this->fileName);
        $fileName = end($pathnameParts);
        $transformedFilePath = str_replace($fileName,'1_'.$fileName,$this->fileName);
        $cmd = $this->ffmpegPath.' -i '.$this->fileName.' -vf scale="'.$this->width.':trunc(ow/a/2)*2" '.$transformedFilePath;
        shell_exec($cmd);
        rename($transformedFilePath,$this->fileName);
        return $this;
    }
    public function setScaleToMaxHeight(){
        /**
         * under Windows there is a problem with shell_exec which gives only null back.
         */
        $pathnameParts = explode('/',$this->fileName);
        $fileName = end($pathnameParts);
        $transformedFilePath = str_replace($fileName,'1_'.$fileName,$this->fileName);
        $cmd = $this->ffmpegPath.' -i '.$this->fileName.' -vf scale="trunc(oh/a/2)*2:'.$this->height.'" '.$transformedFilePath;
        shell_exec($cmd);
        rename($transformedFilePath,$this->fileName);
        return $this;
    }
    public function setCropToMax(){
        /**
         * under Windows there is a problem with shell_exec which gives only null back.
         */
        $pathnameParts = explode(DIRECTORY_SEPARATOR,$this->fileName);
        $fileName = end($pathnameParts);
        $transformedFilePath = str_replace($fileName,'1_'.$fileName,$this->fileName);
        $cmd = $this->ffmpegPath.' -i '.$this->fileName.' -vf crop="'.$this->width.':'.$this->height.'" '.$transformedFilePath;
        shell_exec($cmd);
        rename($transformedFilePath,$this->fileName);
        return $this;
    }
    public function setPng( int $quality = 0){
        /**
         * under Windows there is a problem with shell_exec which gives only null back.
         */
        $this->fileName = str_replace('jpg','png',$this->fileName);
        imagepng($this->file, $this->fileName, $quality);
        $this->file = imagecreatefrompng($this->fileName);
        return $this;
    }
    public function setFromVideo($videoPathname,$getFromXSeconds = 5){
        $cmd = $this->ffmpegPath.' -i '.$videoPathname.' -an -ss '.$getFromXSeconds.' -vf scale="500:trunc(ow/a/2)*2" '.$this->fileName;
        shell_exec($cmd);
        return $this;
    }
}
