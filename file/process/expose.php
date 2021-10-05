<?php

namespace MsPhp\File\Process;

use MsPhp\App\Storage\File;

class Expose {

    protected $result;
    protected $file;

    public function setFile(File $object) {
        $this->file = $object;
        return $this;
    }

    /**
     * <img src="data:image/jpeg;base64,WERTWERTWERTWERTWERdfdhgfdghdhgdfgdf" >
     */
    protected function setResult() {
        $filePath = $this->file->getPathname();
        if (file_exists($filePath)) {
            $fileInfo = new \finfo();
            $type = $fileInfo->file($filePath,FILEINFO_MIME_TYPE);
            $content = $this->file->retrieveString();
            $this->result = 'data:'.$type.';base64,'.base64_encode($content);
        }
    }
    public function getResult() {
        return $this->result;
    }
}
