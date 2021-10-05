<?php
namespace MsPhp\Entity\Attribute\Prototype\Evaluation;

use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeNumericType;
use MsPhp\Entity\Attribute\ForeignKey;
use MsPhp\Entity\Attribute\Prototype\Common\EvaluationType;
use MsPhp\Quality\Entity\QualityBasicNum;
use MsPhp\Quality\Entity\QualityMaxQuantity;
use MsPhp\Quality\Entity\QualityMaxValue;
use MsPhp\Quality\Entity\QualityMinQuantity;
use MsPhp\Quality\Entity\QualityMinValue;

class TypeId extends AttributeNumericType {
    public function __construct() {
        $foreignKey = (new ForeignKey())
            ->setReference(new EvaluationType())
            ->setMatch(ForeignKey::MATCH_SIMPLE)
            ->setOnUpdateAction(ForeignKey::ACTION_CASCADE)
            ->setOnDeleteAction(ForeignKey::ACTION_CASCADE);
        $this->setName('type_id')
            ->setIdValueType(self::ID_VALUE_TYPE_SERIAL)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_SMALLINT)
            ->setDefaultValue(null)
            ->setIsUnique(true)
            ->setIsMultiplePrimaryKey(false)
            ->setForeignKey($foreignKey)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMaxQuantity())->setShallValue(1))
            ->addQuality((new QualityMinValue())->setShallValue(1))
            ->addQuality((new QualityMaxValue())->setShallValue(10))
            ->addQuality(new QualityBasicNum());
    }
}
