<?php
namespace MsPhp\Quality\Entity;

class FileUpload extends Custom {
    /**
     * @return $this|void
     * $isValue = $_FILES['file']['error']
     */
    public function setResult() {
        $result = false;
        switch ($this->isValue) {
            case UPLOAD_ERR_OK:
                $result = true;
                break;
            case UPLOAD_ERR_INI_SIZE:
                $this->labels[] = 'the upload file exceeds the upload_max_filesize directive in php.ini';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->labels[] = 'the upload file exceeds the max_file_size directive that was specified in the html form';
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->labels[] = 'the upload file was only partially uploaded';
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->labels[] = 'No file was uploaded';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->labels[] = 'Missing a temporary folder';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->labels[] = 'Failed to write file to disk';
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->labels[] = 'A php extension stopped the file upload';
                break;
        }
        $this->message = implode(', ',$this->labels);
        $this->result = $result;
        return $this;
    }
}
