<?php
namespace MsPhp\Entity\Attribute\Prototype\Literature;


use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Quality\Entity\QualityBadLanguage;
use MsPhp\Quality\Entity\QualityExtendedAlphaNumSpecial;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMinLength;
use MsPhp\Quality\Entity\QualityMinQuantity;

class Title extends AttributeCharacterType {
    public function __construct() {
        $this->setName('title')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_VARCHAR)
            ->setDefaultValue(null)
            ->setIsUnique(false)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMinLength())->setShallValue(3))
            ->addQuality((new QualityMaxLength())->setShallValue(60))
            ->addQuality(new QualityExtendedAlphaNumSpecial())
            ->addQuality(new QualityBadLanguage());
    }
}
