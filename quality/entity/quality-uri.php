<?php
namespace MsPhp\Quality\Entity;

class QualityUri extends Custom {

    public function setResult(){
        $result = true;
        $uri = $this->isValue;
        $regExpression = "%^(?:(?:https?)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu";
        if((bool) preg_match($regExpression,$uri) === false){
            $result = false;
        } else {
            $restricted = [
                'script',
                'html',
                'console',
                'window',
                'document',
                'alert',
                'location',
                'eval',
                'escape',
                'write',
                'writeln',
                'select',
                'insert',
                'update',
                'delete'
            ];
            foreach($restricted as $item){
                if(stripos($uri,$item) !== false){
                    $result = false;
                    break;
                }
            }
        }
        $this->result = $result;
        return $this;
    }
}
