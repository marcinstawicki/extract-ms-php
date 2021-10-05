<?php
namespace MsPhp\Diagram\Entity;

use MsPhp\Html\Entity\HtmlTemplate;

class Element {
    protected $result;
    protected $variables = [];

    public function __construct() {
        $this->variables['class'] = '';
    }

    public function setClass($class){
        $this->variables['class'] = $class;
        return $this;
    }
    public function setOrder(int $order){
        $this->variables['order'] = $order;
        return $this;
    }
    public function setLevel(int $level){
        $this->variables['level'] = $level;
        return $this;
    }
    public function getResult() {
        return $this->result;
    }

    public function setResult() {
        $classN = str_replace(__NAMESPACE__.'\\','',get_class($this));
        $template = (new HtmlTemplate())
            ->setFile($classN.'.html')
            ->setVariables($this->variables)
            ->setResult();
        $this->result = $template->getResult();
        return $this;
    }
}
