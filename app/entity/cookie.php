<?php
namespace MsPhp\App\Entity;

/**
 * Class Cookie
 * @package MsPhp\Storage
 * setcookie(name, value, expire, path, domain, secure, httponly);
 */
class Cookie extends Storage {
    protected string $name;
    protected string | int $value;
    protected string $result;
    protected int $expire = 0;
    protected string $path = '/';
    protected string $domain;
    protected bool $isSecure = false;
    protected bool $httpOnly = true;
    public function __construct(){
        $this->domain = $_SERVER['HTTP_HOST'];
        $this->isSecure =  $_SERVER['REQUEST_SCHEME'] === 'https';
    }
    public function setName(string $name):Cookie {
        $this->name = $name;
        return $this;
    }
    public function setValue(string | int $value):Cookie {
        $this->value = $value;
        return $this;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getValue()
    {
        return $this->value;
    }

    public function setExpireDays(int $expireDays):Cookie {
        $this->expire = time()+(60*60*24*$expireDays);
        return $this;
    }
    public function setExpireHours(int $expireHours):Cookie {
        $this->expire = time()+(60*60*$expireHours);
        return $this;
    }
    public function setPath(string $path):Cookie {
        $this->path = $path;
        return $this;
    }
    public function setDomain(string $domain):Cookie {
        $this->domain = $domain;
        return $this;
    }
    public function setResult():Cookie{
        $this->result = setrawcookie($this->name, base64_encode($this->value), $this->expire, $this->path, $this->domain, $this->isSecure, $this->httpOnly);
        return $this;
    }
    public function getResult(): string {
        return $this->result;
    }
    public static function retrieve(string $name): string | int | bool {
        return array_key_exists($name,$_COOKIE) ? base64_decode($_COOKIE[$name]) : false;
    }
    public static function remove(string $name){
        $domain = $_SERVER['HTTP_HOST'];
        $isSecure =  $_SERVER['REQUEST_SCHEME'] === 'https';
        if(array_key_exists($name,$_COOKIE)) {
            setcookie($name, "", 1,'/',$domain,$isSecure);
            unset($_COOKIE[$name]);
        }
    }
}