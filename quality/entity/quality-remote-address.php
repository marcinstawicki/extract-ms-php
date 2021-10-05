<?php
namespace MsPhp\Quality\Entity;

class QualityRemoteAddress extends Custom {

    public function setResult(){
        $address = $this->isValue;
        if (empty($address)) {
            $result = false;
        } else {
            $result = filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE);
        }
        $this->result = (bool) $result;
        return $this;
    }
}
