<?php
namespace MsPhp\Quality\Entity;

class QualityHttpUserAgent extends Custom {

    public function setResult(){
        $browsers = array(
            'mozilla',
            'firefox',
            'safari',
            'chrome',
            'edge',
            'msie',
            'like gecko',
            'samsung'
        );
        $agent = strtolower($this->isValue);
        $result = false;
        foreach ($browsers as $browser) {
            if (stripos($agent, $browser) !== false) {
                $result = true;
                break;
            }
        }
        $this->result = $result;
        return $this;
    }
}
