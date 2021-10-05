<?php
namespace MsPhp\App\Process;

use MsPhp\Conversion\Entity\ConversionHyphen;

$path = str_replace('/public','/private',getcwd());
$pathParts = explode('/',$path);
$unset = false;
foreach($pathParts as $key => $part){
    if($unset === true){
        unset($pathParts[$key]);
    }
    if($part === 'private'){
        $unset = true;
    }
}
define('AUTOLOAD_PATH',implode('/',$pathParts).'/');

$dir = dirname(__DIR__,2);
include_once $dir.'/conversion/entity/conversion.php';
include_once $dir.'/conversion/entity/conversion-hyphen.php';

/**
 * Class ClassLoader
 * @package MsPhp\App
 *
 * @important include_once dirname(__DIR__).DIRECTORY_SEPARATOR.'private'.DIRECTORY_SEPARATOR.'MS'.DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR.'ClassLoader.php';
 *            spl_autoload_register('Inclusion::load');
 */
class Incorporate {
    static public function load($className): void {
        $conversion = (new ConversionHyphen())
            ->setString($className)
            ->setResult();
        $classParts = explode('\\',$conversion->getResult());
        $path = AUTOLOAD_PATH;
        foreach($classParts as $part){
            $path.= $part.'/';
        }
        $path = rtrim($path,'/');
        $filename = $path.'.php';
        if (file_exists($filename)) {
            include_once $filename;
        } else {
            if(strpos($className,'\\') !== false){
                die('not: '.$className.' -> '.$filename).PHP_EOL;
            }
        }
    }
}