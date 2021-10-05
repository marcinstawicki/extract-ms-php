<?php
namespace MsPhp\Entity\Attribute\Prototype\Person;

use MsPhp\App\Process\Access;
use MsPhp\Conversion\Entity\ConversionSqlPasswordHash;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMinLength;
use MsPhp\Quality\Entity\QualityMinQuantity;
use MsPhp\Quality\Entity\QualityPasswordStrength;

class Password extends AttributeCharacterType {
    public function __construct() {
        $this->setName('password')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_VARCHAR)
            ->setDefaultValue(null)
            ->setIsUnique(false)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMinLength())->setShallValue(8))
            ->addQuality((new QualityMaxLength())->setShallValue(15))
            ->addQuality(new QualityPasswordStrength())
            ->setConversionToSql(new ConversionSqlPasswordHash());
    }
}
