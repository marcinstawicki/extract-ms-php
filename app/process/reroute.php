<?php

namespace MsPhp\App\Process;

use MsPhp\App\Entity\UriAdvanced;
use MsPhp\Html\Entity\HtmlScriptElement;
use MsPhp\Html\Entity\TextNode;

class Reroute {
    protected string $uri = '';
    protected int $delay = 1000;
    protected string $result = '';

    public function setUri(UriAdvanced $instance): Reroute {
        $this->uri = $instance->setResult()->getResult();
        return $this;
    }
    public function setUriString(string $uri): Reroute {
        $this->uri = $uri;
        return $this;
    }
    public function setDelay(int $delay): Reroute {
        $this->delay = $delay;
        return $this;
    }
    public function setResult(): Reroute {
        $function =<<<TEXT
           window.setTimeout(function(){
               window.location.href = '{$this->uri}';
           },{$this->delay});
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
