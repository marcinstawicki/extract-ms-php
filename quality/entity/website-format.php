<?php
namespace MsPhp\Quality\Entity;

class WebsiteFormat extends RegExp {
    public function __construct(){
        $this->shallValue = '^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$';
        $this->labels = array(
            'http(s)://domain.com'
        );
    }
}
