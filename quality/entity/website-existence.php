<?php

namespace MsPhp\Quality\Entity;

class WebsiteExistence extends WebsiteFormat {

    public function __construct() {
        parent::__construct();
        $labels = array(
            'the website has to exist'
        );
        $this->labels = array_merge($this->labels,$labels);
    }

    public function setResult($value){
        parent::setResult($value);
        if($this->result === true){
            $url = parse_url($value);
            $this->result = checkdnsrr($url['host'], "MX");
        }
        return $this;
    }
}
