<?php
namespace MsPhp\App\Entity;

abstract class UriAbstract {

    protected bool $isAbsolute = false;
    protected string $referer = '';
    protected string $scheme = 'http';
    protected string $host = '';
    protected string $fragment = '';
    protected ?string $result = '';
    protected array | null $query = [];
    protected int $port;

    public function __construct() {
        if(!empty($_SERVER['REQUEST_SCHEME'])) {
            $this->scheme = $_SERVER['REQUEST_SCHEME'];
            $this->host = $_SERVER['HTTP_HOST'];
            $this->port = $_SERVER['SERVER_PORT'];
            $query = parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY);
            parse_str($query,$this->query);
        }
    }
    public function setScheme(string $scheme): self
    {
        $this->scheme = $scheme;
        return $this;
    }
    public function setHost(string $host): self {
        $this->host = $host;
        return $this;
    }
    public function setPort(int $port): self
    {
        $this->port = $port;
        return $this;
    }
    public function setQuery(?array $params = []): self {
        $this->query = $params;
        return $this;
    }
    public function setIsAbsolute(bool $isAbsolute = true): self{
        $this->isAbsolute = $isAbsolute;
        return $this;
    }
    public function setReferer(self $instance): self {
        $this->referer = $instance->setResult()->getResult();
        return $this;
    }
    public function setResult(): self{
        if($this->isAbsolute === true){
            $this->setAbsoluteResult();
        } else {
            $this->setRelativeResult();
        }
        return $this;
    }
    public function getScheme(): string
    {
        return $this->scheme;
    }
    public function getHost(): string
    {
        return $this->host;
    }
    public function getPort(): int
    {
        return $this->port;
    }
    public function getQuery(): array {
        return $this->query;
    }
    public function getResult(): string  {
        return $this->result;
    }
    //
    protected function setAbsoluteResult(): self {
        $this->setRelativeResult();
        $this->result = $this->scheme . '://' . $this->host.$this->result;
        return $this;
    }
    protected function setRelativeResult(): self {
        return $this;
    }
}
