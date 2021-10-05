<?php
namespace MsPhp\Quality\Entity;

use MsPhp\App\Entity\PhraseBook;

abstract class FileType extends Quality {
    protected $types = [];
    protected $labels = ['file with the extension'];
    protected $extension = '';
    protected $result;

    /**
     * $isValue $_FILES[input-field-name][tmp_name]
     * @return $this|void
     */

    public function setResult() {
        $fInfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimetype = $fInfo->file($this->isValue);
        if (array_search($mimetype, $this->types) === false) {
            $label = substr(get_class($this),-3,3);
            $this->result = $label;
        } else {
            $this->result = true;
        }
        $this->message = implode(', ',$this->labels);
        return $this;
    }
}
