<?php
namespace MsPhp\App\Entity;

class Session extends Storage {

    public static function store(string $name, $value): ?bool {
        return !array_key_exists($name,$_SESSION) ? (bool) $_SESSION[$name] = $value : false;
    }
    public static function retrieve(string $name) {
        return array_key_exists($name,$_SESSION) ? $_SESSION[$name] : false;
    }
    public static function remove(string $name){
        if(array_key_exists($name,$_SESSION)) {
            unset($_SESSION[$name]);
            return true;
        } else {
            return false;
        }
    }
    public static function replace(string $name, $value): ?bool {
        $result = false;
        if(array_key_exists($name,$_SESSION)){
            $_SESSION[$name] = $value;
            $result = true;
        }
        return $result;
    }
}

