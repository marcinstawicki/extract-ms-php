<?php
namespace MsPhp\Entity\Attribute\Prototype\Person;


use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Quality\Entity\QualityBadLanguage;
use MsPhp\Quality\Entity\QualityEmailFormat;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMaxQuantity;
use MsPhp\Quality\Entity\QualityMinLength;

class Photo extends AttributeCharacterType {
    public function __construct() {
        $this->setName('photo')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_VARCHAR)
            ->setDefaultValue(null)
            ->setIsUnique(false)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMaxQuantity())->setShallValue(1))
            ->addQuality((new QualityMinLength())->setShallValue(7))
            ->addQuality((new QualityMaxLength())->setShallValue(60))
            ->addQuality((new QualityEmailFormat()))
            ->addQuality(new QualityBadLanguage());
    }
}
