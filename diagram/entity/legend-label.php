<?php
namespace MsPhp\Diagram\Entity;

use MsPhp\App\Entity\Env;
use MsPhp\Html\Entity\HtmlTemplate;

class LegendLabel {
    protected $result;
    protected $text;
    protected $order;

    public function __construct() {}

    public function setText($text) {
        $this->text = $text;
        return $this;
    }
    public function setOrder(int $order) {
        $this->order = $order;
        return $this;
    }

    public function getResult() {
        return $this->result;
    }
    public function setResult() {
        $template = (new HtmlTemplate())
            ->setFile('LegendLabel.html')
            ->setVariables(array(
                'order' => $this->order,
                'text' => Env::translation($this->text)
            ))
            ->setResult();
        $this->result = $template->getResult();
        return $this;
    }
}
