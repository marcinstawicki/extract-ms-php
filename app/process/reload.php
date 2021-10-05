<?php

namespace MsPhp\App\Process;

use MsPhp\Html\Entity\HtmlScriptElement;
use MsPhp\Html\Entity\TextNode;

class Reload {

    protected int $delay = 0;
    protected string $result;

    public function setDelay(int $delay): Reload {
        $this->delay = $delay;
        return $this;
    }
    public function setResult(): Reload {
        $function =<<<TEXT
           window.setTimeout(function(){
               window.location.reload(true);
           },$this->delay);
TEXT;
        $script = (new HtmlScriptElement())
            ->addChild(new TextNode($function))
            ->setResult();
        $this->result = $script->getResult();
        return $this;
    }
    public function getResult(): string {
        return $this->result;
    }

}
