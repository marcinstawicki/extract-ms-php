<?php
namespace MsPhp\Entity\Attribute\Prototype\Offset;

class NextPageId extends PageId {
    public function __construct() {
        parent::__construct();
        $this->setName('next_page_id');
    }
}
