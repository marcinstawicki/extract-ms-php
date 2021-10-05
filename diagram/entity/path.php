<?php
namespace MsPhp\Diagram\Entity;

class Path extends Element {
    protected $d = [];
    protected $moveTo;
    protected $lineTo;
    protected $horizontalLineTo;
    protected $verticalLineTo;
    protected $curveTo;
    protected $smoothCurveTo;
    protected $quadraticCurveTo;
    protected $smoothQuadraticCurveTo;
    protected $ellipticalArc;
    protected $closePath;
    const D_TYPE_ABSOLUTE = 'absolute';
    const D_TYPE_RELATIVE = 'relative';

    public function __construct() {
        $this->variables['d'] = '';
        parent::__construct();
    }
    public function addMoveTo($type = self::D_TYPE_ABSOLUTE,$x,$y) {
        $prefix = 'M';
        if($type === self::D_TYPE_RELATIVE){
            $prefix = strtolower($prefix);
        }
        $this->variables['d'].= $prefix.$x.' '.$y.' ';
        return $this;
    }

    public function addLineTo($type = self::D_TYPE_ABSOLUTE,$x,$y) {
        $prefix = 'L';
        if($type === self::D_TYPE_RELATIVE){
            $prefix = strtolower($prefix);
        }
        $this->variables['d'].= $prefix.$x.' '.$y.' ';
        return $this;
    }

    public function addHorizontalLineTo($type = self::D_TYPE_ABSOLUTE,$x) {
        $prefix = 'H';
        if($type === self::D_TYPE_RELATIVE){
            $prefix = strtolower($prefix);
        }
        $this->variables['d'].= $prefix.$x.' ';
        return $this;
    }

    public function addVerticalLineTo($type = self::D_TYPE_ABSOLUTE,$y) {
        $prefix = 'V';
        if($type === self::D_TYPE_RELATIVE){
            $prefix = strtolower($prefix);
        }
        $this->variables['d'].= $prefix.$y.' ';
        return $this;
    }

    public function addCurveTo() {
        return $this;
    }

    public function addSmoothCurveTo() {
        return $this;
    }

    public function addQuadraticCurveTo() {
        return $this;
    }

    public function addSmoothQuadraticCurveTo() {
        return $this;
    }

    public function addEllipticalArc($type = self::D_TYPE_ABSOLUTE,$rx,$ry,$xAxisRotation,$largeArcFlag,$sweepFlag,$x,$y) {
        $prefix = 'A';
        if($type === self::D_TYPE_RELATIVE){
            $prefix = strtolower($prefix);
        }
        $this->variables['d'].= $prefix.$rx.' '.$ry.' '.$xAxisRotation.' '.$largeArcFlag.' '.$sweepFlag.' '.$x.' '.$y.' ';
        return $this;
    }

    public function setClosePath($type = self::D_TYPE_ABSOLUTE) {
        $prefix = 'Z';
        if($type === self::D_TYPE_RELATIVE){
            $prefix = strtolower($prefix);
        }
        $this->variables['d'].= $prefix;
        return $this;
    }
}
