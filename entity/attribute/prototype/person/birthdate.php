<?php
namespace MsPhp\Entity\Attribute\Prototype\Person;

use MsPhp\App\Process\Access;
use MsPhp\Conversion\Entity\ConversionSqlDateTime;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Quality\Entity\QualityDate;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMinLength;
use MsPhp\Quality\Entity\QualityMinQuantity;

class Birthdate extends AttributeCharacterType {
    public function __construct() {
        $this->setName('birthdate')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_VARCHAR)
            ->setDefaultValue(null)
            ->setIsUnique(false)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMinLength())->setShallValue(10))
            ->addQuality((new QualityMaxLength())->setShallValue(10))
            ->addQuality((new QualityDate()))
            ->setConversionToSql(new ConversionSqlDateTime());
    }
}
