<?php
namespace MsPhp\Entity\Attribute\Prototype\BusinessTransactionRequirement;

use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Quality\Entity\QualityExtendedAlphaNumSpaceSpecial;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMinLength;
use MsPhp\Quality\Entity\QualityMinQuantity;

class Description extends AttributeCharacterType {
    public function __construct() {
        $this->setName('description')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_VARCHAR)
            ->setDefaultValue(null)
            ->setIsUnique(true)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMinLength())->setShallValue(1))
            ->addQuality((new QualityMaxLength())->setShallValue(250))
            ->addQuality(new QualityExtendedAlphaNumSpaceSpecial());
    }
}
