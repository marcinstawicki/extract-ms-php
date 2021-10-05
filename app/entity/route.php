<?php
namespace MsPhp\App\Entity;

use MsPhp\Conversion\Entity\ConversionCamelCase;

/**
 * Class Route
 * @package MsPhp\App\Entity
 * hostname.com/en/3?s=hfjdlsakjdhfjdslkajdhfjsahdfkjhasldf
 */
class Route {

    protected $result = 0;

    public function setIndexCheckpointID(int $checkpointID) {
        $this->result = $checkpointID;
        return $this;
    }
    public function setResult() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if($path !== '/'){
            $pathElements = explode('/', $path);
            if (count($pathElements) === 2 && is_numeric($pathElements[1])) {
               $this->result = $pathElements[1];
            }
        }
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}
