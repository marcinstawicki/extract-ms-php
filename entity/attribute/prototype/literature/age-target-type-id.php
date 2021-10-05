<?php
namespace MsPhp\Entity\Attribute\Prototype\Literature;

use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeNumericType;
use MsPhp\Entity\Attribute\ForeignKey;
use MsPhp\Entity\Attribute\Prototype\Common\AgeTargetType;
use MsPhp\Quality\Entity\QualityBasicNum;
use MsPhp\Quality\Entity\QualityMaxQuantity;
use MsPhp\Quality\Entity\QualityMaxValue;
use MsPhp\Quality\Entity\QualityMinQuantity;
use MsPhp\Quality\Entity\QualityMinValue;

class AgeTargetTypeId extends AttributeNumericType {
    public function __construct() {
        $foreignKey = (new ForeignKey())
            ->setReference(new AgeTargetType())
            ->setMatch(ForeignKey::MATCH_SIMPLE)
            ->setOnUpdateAction(ForeignKey::ACTION_CASCADE)
            ->setOnDeleteAction(ForeignKey::ACTION_CASCADE);
        $this->setName('age_target_type_id')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_SMALLINT)
            ->setDefaultValue(null)
            ->setIsUnique(false)
            ->setIsMultiplePrimaryKey(false)
            ->setForeignKey($foreignKey)
            ->addQuality((new QualityMinQuantity())->setShallValue(0))
            ->addQuality((new QualityMaxQuantity())->setShallValue(1))
            ->addQuality((new QualityMinValue())->setShallValue(3))
            ->addQuality((new QualityMaxValue())->setShallValue(15))
            ->addQuality(new QualityBasicNum());
    }
}
