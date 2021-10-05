<?php
namespace MsPhp\App\Entity;

class Uri extends UriAbstract {

    protected string | null $path = '';

    public function __construct() {
        parent::__construct();
        if(isset($_SERVER['REQUEST_URI'])){
            $this->path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
        }
    }
    public function setPath(string $path): self {
        $this->path = $path;
        return $this;
    }
    public function getPath()
    {
        return $this->path;
    }
    //
    protected function setAbsoluteResult(): self {
        $this->setRelativeResult();
        $this->result = $this->scheme . '://' . $this->host.$this->result;
        return $this;
    }
    protected function setRelativeResult(): self {
        $result = $this->path;
        if (!empty($this->query)) {
            $result .= '?' . http_build_query($this->query);
        }
        if (!empty($this->fragment)) {
            $result .= '#' . $this->fragment;
        }
        $this->result = $result;
        return $this;
    }
}
