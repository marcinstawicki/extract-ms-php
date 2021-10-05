<?php

namespace MsPhp\FileCache\Entity;

use MsPhp\App\Entity\Env;
use MsPhp\App\Entity\Storage;

abstract class FileCache extends Storage {

    final public static function set(string $key, $data, string $storagePath){
        if(is_object($data)){
            $data = serialize($data);
        }
        $str = preg_replace('/\s+/', ' ', var_export($data, true));
        if(is_array($data)){
            $str = strtr($str, [
                "array ( " => "[",
                "', )" => "']",
                ", )" => "]"
                ]);
        }
        $str = '<?php return ' . $str . ';';
        $class = strtolower(str_replace('MsPhp\FileCache\Entity\FileCache','',get_called_class()));
        $file = $storagePath.'/cache/'.$class.'/'.$key.'.php';
        file_put_contents($file, $str);
    }

    final public static function get(string $key,string $storagePath) {
        $class = strtolower(str_replace('MsPhp\FileCache\Entity\FileCache','',get_called_class()));
        $file = $storagePath.'/cache/'.$class.'/'.$key.'.php';
        if(file_exists($file)){
            $result = include_once $file;
            if(is_string($result)){
                $isObject = @unserialize($result);
                if($isObject !== false){
                    $result = $isObject;
                }
            }
        } else {
            $result =  null;
        }
        return $result;
    }
    final public static function unset(string $key,string $storagePath){
        $class = strtolower(str_replace('MsPhp\FileCache\Entity\FileCache','',get_called_class()));
        $file = $storagePath.'/cache/'.$class.'/'.$key.'.php';
        $result = true;
        if(file_exists($file)){
            $result = unlink($file);
        }
        return $result;
    }
    final public static function clear(string $storagePath){
        $class = strtolower(str_replace('MsPhp\FileCache\Entity\FileCache','',get_called_class()));
        $folder = $storagePath.'/cache/'.$class;
        $times = [
            'minute' => 60,
            'hour' => 60*60,
            'day' => 60*60*24,
            'week' => 60*60*24*7
        ];
        $diff = $times[$class];
        foreach (new \DirectoryIterator($folder) as $fileInfo) {
            if($fileInfo->isDot()) continue;
            if(time() - $fileInfo->getMTime() > $diff){
                unlink($fileInfo->getRealPath());
            }
        }
    }
}