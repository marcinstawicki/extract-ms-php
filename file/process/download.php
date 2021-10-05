<?php

namespace MsPhp\File\Process;

use MsPhp\App\Storage\File;

class Download {

    const CONTENT_DISPOSITION_ATTACHMENT = 'attachment';
    const CONTENT_DISPOSITION_INLINE = 'inline';
    protected $contentDisposition = self::CONTENT_DISPOSITION_ATTACHMENT;
    protected $directory;
    protected $filename;
    protected $result;

    public function setDirectory(string $directory) {
        $this->directory = $directory;
        return $this;
    }
    public function setFilename(string $filename) {
        $this->filename = $filename;
        return $this;
    }
    public function setContentDisposition(string $contentDisposition) {
        $this->contentDisposition = $contentDisposition;
        return $this;
    }
    public function setResult() {
        $fullPath = $this->directory.DIRECTORY_SEPARATOR.$this->filename;
        if(file_exists($fullPath)){
            $file = new File($fullPath);
            $fileInfo = new \finfo();
            $type = $fileInfo->file($file->getPathname(),FILEINFO_MIME_TYPE);
            $basename = $file->getBasename();
            $size = $file->getSize();
            header('Content-Description: File Transfer');
            header('Content-Type: '.$type);
            header('Content-Disposition: '.$this->contentDisposition.'; filename="'.$basename.'"' );
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . $size);
            $this->result = $file->getPathname();
        }
        return $this;
    }
    public function getResult() {
        if(!is_null($this->result)){
            readfile($this->result);
            die();
        }
    }
}
