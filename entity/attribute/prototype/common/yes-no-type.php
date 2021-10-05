<?php
namespace MsPhp\Entity\Attribute\Prototype\Common;


use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Quality\Entity\QualityBadLanguage;
use MsPhp\Quality\Entity\QualityMinQuantity;

class YesNoType extends AttributeCharacterType {
    public function __construct() {
        $this->setName('type_yes_no')
            ->setIdValueType(self::ID_VALUE_TYPE_SMALLSERIAL)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_VARCHAR)
            ->setDefaultValue(null)
            ->setIsUnique(true)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality(new QualityBadLanguage());
    }
}
