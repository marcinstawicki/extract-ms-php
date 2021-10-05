<?php
namespace MsPhp\Entity\Attribute\Prototype\LiteratureSentence;


use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Entity\Attribute\AttributeNumericType;
use MsPhp\Quality\Entity\QualityBadLanguage;
use MsPhp\Quality\Entity\QualityExtendedAlphaNumSpecial;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMinLength;
use MsPhp\Quality\Entity\QualityMinQuantity;

class Sort extends AttributeNumericType {
    public function __construct() {
        $this->setName('sort')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_SMALLINT)
            ->setDefaultValue(null)
            ->setIsUnique(false)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMinLength())->setShallValue(1))
            ->addQuality((new QualityMaxLength())->setShallValue(2))
            ->addQuality(new QualityExtendedAlphaNumSpecial())
            ->addQuality(new QualityBadLanguage());
    }
}
