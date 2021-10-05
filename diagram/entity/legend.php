<?php
namespace MsPhp\Diagram\Entity;

use MsPhp\Html\Entity\HtmlTemplate;

class Legend {
    protected $result;
    protected $labels;

    public function getResult() {
        return $this->result;
    }

    public function addLabel(LegendLabel $object) {
        $this->labels.= $object->setResult()->getResult();
        return $this;
    }

    public function setResult() {
        $template = (new HtmlTemplate())
            ->setFile('Legend.html')
            ->setVariables(array(
                'labels' => $this->labels
            ))
            ->setResult();
        $this->result = $template->getResult();
        return $this;
    }
}
