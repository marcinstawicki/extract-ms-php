<?php
namespace MsPhp\Entity\Attribute\Prototype\Literature;


use MsPhp\App\Process\Access;
use MsPhp\Conversion\Entity\ConversionSqlDateTime;
use MsPhp\Conversion\Entity\ConversionUserDateTime;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Entity\Attribute\AttributeDatetimeType;
use MsPhp\Quality\Entity\QualityBadLanguage;
use MsPhp\Quality\Entity\QualityExtendedAlphaNumSpecial;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMinLength;
use MsPhp\Quality\Entity\QualityMinQuantity;

class Datetime extends AttributeDatetimeType {
    public function __construct() {
        $this->setName('datetime')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_TIMESTAMP)
            ->setDefaultValue(null)
            ->setIsUnique(false)
            ->setIsMultiplePrimaryKey(false)
            ->setConversionToSql(new ConversionSqlDateTime())
            ->setConversionFromSql(new ConversionUserDateTime());
    }
}
