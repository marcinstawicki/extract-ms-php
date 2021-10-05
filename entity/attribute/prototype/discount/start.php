<?php
namespace MsPhp\Entity\Attribute\Prototype\Event;

use MsPhp\App\Process\Access;
use MsPhp\Conversion\Entity\ConversionSqlDateTime;
use MsPhp\Conversion\Entity\ConversionUserDateTime;
use MsPhp\Entity\Attribute\AttributeDatetimeType;

class Start extends AttributeDatetimeType {
    public function __construct() {
        $this->setName('start')
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
