<?php
namespace MsPhp\Entity\Attribute\Prototype\BusinessTransaction;

use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Quality\Entity\QualityExtendedAlphaNumSpaceSpecial;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMinLength;
use MsPhp\Quality\Entity\QualityMinQuantity;

class Identifier extends AttributeCharacterType {
    public function __construct() {
        $this->setName('identifier')
            ->setIdValueType(self::ID_VALUE_TYPE_SERIAL)
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
