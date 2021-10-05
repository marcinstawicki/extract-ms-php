<?php
namespace MsPhp\App\Entity;

abstract class Service {
    protected array | string | int | float | bool | object | null $result;
    protected string $scheme;
    protected string $name;
    protected string $host;
    protected int $port;
    protected string $userName;
    protected string $password;

    public function setName(string $name): Service {
        $this->name = $name;
        return $this;
    }
    public function setScheme(string $scheme): Service {
        $this->scheme = $scheme;
        return $this;
    }
    public function setHost(string $host): Service {
        $this->host = $host;
        return $this;
    }
    public function setPort(int $port): Service  {
        $this->port = $port;
        return $this;
    }
    public function setUserName(string $userName): Service {
        $this->userName = $userName;
        return $this;
    }
    public function setPassword(string $password): Service {
        $this->password = $password;
        return $this;
    }
    public function getName(): string {
        return $this->name;
    }
    public function getScheme(): string {
        return $this->scheme;
    }
    public function getHost(): string {
        return $this->host;
    }
    public function getPort(): int {
        return $this->port;
    }
    public function getUserName(): string {
        return $this->userName;
    }
    public function getPassword(): string  {
        return $this->password;
    }
    public function getResult(): array | string | int | float | bool | object | null  {
        return $this->result;
    }
}
