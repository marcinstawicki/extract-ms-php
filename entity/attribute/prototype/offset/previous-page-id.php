<?php
namespace MsPhp\Entity\Attribute\Prototype\Offset;

use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeNumericType;
use MsPhp\Quality\Entity\QualityBasicNum;
use MsPhp\Quality\Entity\QualityMaxQuantity;
use MsPhp\Quality\Entity\QualityMinQuantity;
use MsPhp\Quality\Entity\QualityMinValue;

class PreviousPageId extends PageId {
    public function __construct() {
        parent::__construct();
        $this->setName('previous_page_id');
    }
}
