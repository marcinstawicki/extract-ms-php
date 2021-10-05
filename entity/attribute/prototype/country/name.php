<?php
namespace MsPhp\Entity\Attribute\Prototype\Country;


use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Quality\Entity\QualityBadLanguage;
use MsPhp\Quality\Entity\QualityExtendedAlphaNumSpaceSpecial;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMinLength;
use MsPhp\Quality\Entity\QualityMinQuantity;

class Name extends AttributeCharacterType {
    public function __construct() {
        $this->setName('name')
            ->setIdValueType(self::ID_VALUE_TYPE_SMALLINT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_VARCHAR)
            ->setDefaultValue(null)
            ->setIsUnique(true)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMinLength())->setShallValue(5))
            ->addQuality((new QualityMaxLength())->setShallValue(60))
            ->addQuality(new QualityExtendedAlphaNumSpaceSpecial())
            ->addQuality(new QualityBadLanguage());
    }
}
