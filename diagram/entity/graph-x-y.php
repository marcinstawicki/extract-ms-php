<?php
namespace MsPhp\Diagram\Entity;

use MsPhp\App\Entity\Resource;
use MsPhp\Html\Entity\HtmlTemplate;

class GraphXY {
    protected $class;
    protected $data;
    protected $viewHeight = 300;
    protected $viewWidth = 600;
    protected $scales;
    protected $rectangleWidth = 5;
    protected $minAxisXStep = 20;
    protected $minAxisYStep = 5;
    protected $axisX;
    protected $axisY;
    protected $axisXLabels;
    protected $axisYLabels;
    protected $verticalSupportLines;
    protected $horizontalSupportLines;
    protected $result;
    const RESULT_TYPE_POLYLINE = 'polyline';
    const RESULT_TYPE_RECT = 'rect';

    public function __construct(array $data){
        $this->data = $data;
        $widths = [];
        $scales = [];
        foreach($data as $label => $params){
            $widths[] = count($params);
            $scales[] = max($params);
        }
        $this->viewWidth = max($widths) * $this->minAxisXStep;
        $this->scales = max($scales);
        if($this->viewWidth < 900){
            $this->viewWidth = 900;
            $this->minAxisXStep = $this->viewWidth/max($widths);
        }
    }

    public function setClass($class) {
        $this->class = $class;
        return $this;
    }

    public function setViewHeight($viewHeight) {
        $this->viewHeight = $viewHeight;
        return $this;
    }

    public function setViewWidth($viewWidth) {
        $this->viewWidth = $viewWidth;
        return $this;
    }

    public function setAxisX() {
        $y = $this->viewHeight;
        $x = 0;
        $group =  new Group();
        $line = (new Line)
            ->setX1($x)
            ->setY1($y)
            ->setX2($this->viewWidth)
            ->setY2($y)
            ->setClass('ms-svg-line-axis-x');
        $group->addElement($line);
        $this->axisX = $group;
        return $this;
    }

    public function setAxisY() {
        $y = 0;
        $y2 = $this->viewHeight;
        $x = 100 - 5;
        $group =  new Group();
        $line = (new Line)
            ->setX1($x)
            ->setY1($y)
            ->setX2($x)
            ->setY2($y2)
            ->setClass('ms-svg-line-axis-y');
        $group->addElement($line);
        $this->axisY = $group;
        return $this;
    }

    public function setVerticalSupportLines() {
        //keys are X-attributes
        $textY = 0;
        $this->verticalSupportLines = new Group();
        $this->axisXLabels = new Group();
        $count = 0;
        foreach($this->data as $nLabel => $params) {
            foreach($params as $label => $value){
                $y = $this->viewHeight;
                $x = ($this->minAxisXStep*$count);
                $line = (new Line)
                    ->setX1($x)
                    ->setY1(0)
                    ->setX2($x)
                    ->setY2($y)
                    ->setClass('ms-svg-line-vertical');
                $this->verticalSupportLines->addElement($line);
                $text = (new Text)
                    ->setX($x)
                    ->setY($textY)
                    ->setLabel($label)
                    ->setClass('ms-svg-text-horizontal ms-svg-text-horizontal-axis-x');
                $this->axisXLabels->addElement($text);
                $count++;
            }
            break;
        }
        return $this;
    }

    public function setHorizontalSupportLines() {
        //values are Y-attributes
        $max = $this->scales;
        $valueStep = round($max/$this->minAxisYStep,2);
        $axisStep = round($this->viewHeight / $this->minAxisYStep,2);
        $range = range(0,$this->minAxisYStep+1);
        $this->horizontalSupportLines = new Group();
        $this->axisYLabels =  new Group();
        foreach($range as $elementNumber) {
            $y = $this->viewHeight - ($elementNumber * $axisStep);
            $x1 = 0;
            $x2 = $this->viewWidth;
            $line = (new Line)
                ->setX1($x1)
                ->setY1($y)
                ->setX2($x2)
                ->setY2($y)
                ->setClass('ms-svg-line ms-svg-line-horizontal');
            $this->horizontalSupportLines->addElement($line);
            $textX = 100 - 10;
            $textY = $y+4;
            $yLabel = round($elementNumber * $valueStep,2);
            $text = (new Text)
                ->setX($textX)
                ->setY($textY)
                ->setLabel($yLabel)
                ->setClass('ms-svg-text-horizontal ms-svg-text-horizontal-axis-y');
            $this->axisYLabels->addElement($text);
        }
        return $this;
    }

    public function setResult($type = self::RESULT_TYPE_POLYLINE) {
        $max = $this->scales;
        /**
         * workspace
         */
        $svg = (new Svg())
            ->setHeight($this->viewHeight)
            ->setWidth($this->viewWidth)
            ->setViewBox(-5,-5,$this->viewWidth,$this->viewHeight)
            ->addGroup($this->horizontalSupportLines)
            ->addGroup($this->verticalSupportLines);
        $legend = new Legend();
        foreach($this->data as $nLabel => $params){
            $nLabelGroup = (new Group())->setClass($nLabel);
            $rectangles = (new Group())->setClass($nLabel.'-rectangles');
            $circles = (new Group())->setClass($nLabel.'-circles');
            $polyLine = (new PolyLine());
            $count = 0;
            foreach($params as $x => $y){
                $y = ($y*$this->viewHeight)/$max;
                $h = $y;
                $y = $this->viewHeight - $h;
                $x = ($count * $this->minAxisXStep);
                $polyLine->addPoint($x,$y);
                $rectX = $x - $this->rectangleWidth/2;
                $rectangle  = (new Rect())
                    ->setX($rectX)
                    ->setY($y)
                    ->setWidth($this->rectangleWidth)
                    ->setHeight($h);
                $rectangles->addElement($rectangle);
                $circle  = (new Circle())
                    ->setR(4)->setCy($y)->setCx($x);
                $circles->addElement($circle);
                $count++;
            }
            if($type === self::RESULT_TYPE_POLYLINE){
                $group = (new Group())->setClass($nLabel.'-polyline');
                $group->addElement($polyLine);
                $nLabelGroup->addElement($group)
                    ->addElement($circles);
            } else if($type === self::RESULT_TYPE_RECT) {
                $nLabelGroup->addElement($rectangles);
            }
            $svg->addGroup($nLabelGroup);
            $legendLabel = (new LegendLabel())
                ->setIdentifier('ms-svg-legend-label-circle-'.$nLabel)
                ->setText($nLabel);
            $legend->addLabel($legendLabel);
        }
        $svgH = $svg->setResult()->getResult();
        $template = (new HtmlTemplate())
            ->setFile('Division.html')
            ->setVariables(array(
                'division' => $svgH,
                'class' => ' ms-svg-graph-workspace-panel',
            ));
        $workSpace = $template->setResult()->getResult();
        /**
         * left panel
         */
        $svg = (new Svg())
            ->setHeight($this->viewHeight)
            ->setViewBox(0,-5,100,$this->viewHeight)
            ->setWidth(100)
            ->addGroup($this->axisY)
            ->addGroup($this->axisYLabels);
        $svgH = $svg->setResult()->getResult();
        $template = (new HtmlTemplate())
            ->setFile('Division.html')
            ->setVariables(array(
                'division' => $svgH,
                'class' => ' ms-svg-graph-left-panel',
            ));
        $graph = $template->setResult()->getResult();
        /**
         * bottom
         */
        $svg = (new Svg())
            ->setHeight(75)
            ->setWidth($this->viewWidth)
            ->setViewBox(-5,-5,$this->viewWidth,75)
            ->addGroup($this->axisX)
            ->addGroup($this->axisXLabels)
            ->setClass('ms-svg-bottom-panel');
        $svgH = $svg->setResult()->getResult();
        $template = (new HtmlTemplate())
            ->setFile('Division.html')
            ->setVariables(array(
                'division' => $svgH,
                'class' => ' ms-svg-graph-bottom-panel',
            ));
        $bottomPanel = $template->setResult()->getResult();
        /**
         * right panel
         */
        $template = (new HtmlTemplate())
            ->setFile('Division.html')
            ->setVariables(array(
                'division' => $workSpace.$bottomPanel,
                'class' => ' ms-svg-graph-right-panel',
            ));
        $graph.= $template->setResult()->getResult();
        /**
         * graph
         */
        $template = (new HtmlTemplate())
            ->setFile('Division.html')
            ->setVariables(array(
                'division' => $graph,
                'class' => ' ms-svg-graph '.$this->class
            ))
            ->setResult();
        $this->result = $legend->setResult()->getResult();
        $this->result.= $template->getResult();
        return $this;
    }

    public function getResult(){
        return $this->result;
    }
}
