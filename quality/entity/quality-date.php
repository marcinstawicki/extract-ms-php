<?php
namespace MsPhp\Quality\Entity;

use MsPhp\App\Entity\Env;

class QualityDate extends Custom {

    public function __construct(){
        $locale = Env::user()->getLocale();
        $label1 = in_array($locale,['us','ca']) ? 'month/day/year' : 'day-month-year';
        $label2 = in_array($locale,['us','ca']) ? 'xx/xx/xxxx' : 'xx-xx-xxxx';
        $this->labels = array(
            $label1,
            $label2
        );
    }

    public function setResult() {
        if(!is_array($this->isValue)){
            $this->isValue = [$this->isValue];
        }
        try {
            new \DateTime($this->isValue[0]);
            $this->result = true;
        } catch(\Exception $e){
            $this->result = false;
        }
        foreach($this->labels as &$label){
            $label = Env::translation($label);
        }
        $this->message = implode(', ',$this->labels);
        return $this;
    }
}
