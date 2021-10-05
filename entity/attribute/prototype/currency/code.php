<?php
namespace MsPhp\Entity\Attribute\Prototype\Currency;

use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Quality\Entity\QualityBasicAlpha;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMinLength;
use MsPhp\Quality\Entity\QualityMinQuantity;

class Code extends AttributeCharacterType {
    public function __construct() {
        $this->setName('code')
            ->setIdValueType(self::ID_VALUE_TYPE_SMALLSERIAL)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_CHAR)
            ->setDefaultValue(null)
            ->setIsUnique(true)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMinLength())->setShallValue(2))
            ->addQuality((new QualityMaxLength())->setShallValue(2))
            ->addQuality(new QualityBasicAlpha());
    }
}
