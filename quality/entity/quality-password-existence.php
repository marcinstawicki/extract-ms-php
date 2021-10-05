<?php

namespace MsPhp\Quality\Entity;

class QualityPasswordExistence extends DatabaseValueExistence {
    public function __construct() {
        parent::__construct();
        $this->labels = array(
            'the password has to exit',
        );
    }
}
