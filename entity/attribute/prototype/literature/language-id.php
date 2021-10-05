<?php
namespace MsPhp\Entity\Attribute\Prototype\Literature;

use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeNumericType;
use MsPhp\Entity\Attribute\ForeignKey;
use MsPhp\Entity\Attribute\Prototype\Language\Alpha2;
use MsPhp\Quality\Entity\QualityBasicNum;
use MsPhp\Quality\Entity\QualityMaxQuantity;
use MsPhp\Quality\Entity\QualityMinQuantity;
use MsPhp\Quality\Entity\QualityMinValue;

class LanguageId extends AttributeNumericType {
    public function __construct() {
        $foreignKey = (new ForeignKey())
            ->setReference(new Alpha2())
            ->setMatch(ForeignKey::MATCH_SIMPLE)
            ->setOnUpdateAction(ForeignKey::ACTION_CASCADE)
            ->setOnDeleteAction(ForeignKey::ACTION_CASCADE);
        $this->setName('language_id')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_SMALLINT)
            ->setDefaultValue(null)
            ->setIsUnique(false)
            ->setForeignKey($foreignKey)
            ->setIsMultiplePrimaryKey(true)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMaxQuantity())->setShallValue(1))
            ->addQuality((new QualityMinValue())->setShallValue(1))
            ->addQuality(new QualityBasicNum());
    }
}
