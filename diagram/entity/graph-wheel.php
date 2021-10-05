<?php
namespace MsPhp\Diagram\Entity;

use MsPhp\Html\Entity\HtmlDivElement;

class GraphWheel extends HtmlDivElement {
    protected $data;
    protected $outerRadius = 400;
    protected $innerRadius = 0;
    protected $innerLabel = '';
    protected $isLegend = false;
    protected $order = 0;
    protected $level = 0;
    protected $result;

    public function setData(array $data) {
        $sum = array_sum($data);
        if($sum > 100){
            $data = array(100 => '');
        } if($sum < 100){
            $data[''] = 100 - $sum;
        }
        $this->data = $data;
        return $this;
    }
    public function setOuterRadius(int $outerRadius) {
        $this->outerRadius = $outerRadius;
        return $this;
    }
    public function setInnerRadius(int $innerRadius) {
        $this->innerRadius = $innerRadius;
        return $this;
    }
    public function setInnerLabel(string $innerLabel) {
        $this->innerLabel = $innerLabel;
        return $this;
    }
    public function setIsLegend(bool $isLegend) {
        $this->isLegend = $isLegend;
        return $this;
    }

    public function setResult() {
        $group0 = (new Group())
            ->setOrder(0)
            ->setClass('element');
        $Lx = $this->outerRadius;
        $Ly = 0;
        $previousDegrees = 0;
        $count = 0;
        $legend = new Legend();
        foreach($this->data as $label => $percentage){
            $degree = $percentage * 360 / 100;
            $largeArcFlag = $degree > 180 ? 1 : 0;
            $x = $this->outerRadius + $this->outerRadius * cos(deg2rad(90 + $previousDegrees - $degree));
            $y = $this->outerRadius - $this->outerRadius * sin(deg2rad(90 + $previousDegrees - $degree));
            $previousDegrees -= $degree;
            $path = (new Path())
                ->addMoveTo(Path::D_TYPE_ABSOLUTE,$this->outerRadius,$this->outerRadius)
                ->addLineTo(Path::D_TYPE_ABSOLUTE,$Lx,$Ly)
                ->addEllipticalArc(Path::D_TYPE_ABSOLUTE, $this->outerRadius,$this->outerRadius,0,$largeArcFlag,1,$x,$y)
                ->setClosePath(Path::D_TYPE_ABSOLUTE)
                ->setOrder($count)
                ->setClass('element');
            $group0->addElement($path);
            $legendLabel = (new LegendLabel())
                ->setOrder($count)
                ->setText($label);
            $legend->addLabel($legendLabel);
            $Lx = $x;
            $Ly = $y;
            $count++;
        }
        $svg = (new Svg())
            ->setOrder(0)
            ->setLevel($this->level)
            ->setClass('element')
            ->setHeight($this->outerRadius * 2)
            ->setWidth($this->outerRadius * 2)
            ->addGroup($group0);
        if(!empty($this->innerRadius)){
            $group1 = (new Group())
                ->setOrder(1)
                ->setClass('element');
            $circle = (new Circle())
                ->setOrder(0)
                ->setClass('element')
                ->setR($this->innerRadius)
                ->setCx($this->outerRadius)
                ->setCy($this->outerRadius);
            $group1->addElement($circle);
            $text = (new Text())
                ->setOrder(1)
                ->setClass('element')
                ->setX($this->outerRadius)
                ->setY($this->outerRadius)
                ->setDx('0')
                ->setDy('7%')
                ->setLabel($this->innerLabel);
            $group1->addElement($text);
            $svg->addGroup($group1);
        }
        $svg->setResult();
        $this->result = $svg->getResult();
        if($this->isLegend === true){
            $this->result.= $legend->setResult()->getResult();
        }
        return $this;
    }
    public function getResult(){
        return $this->result;
    }
}
