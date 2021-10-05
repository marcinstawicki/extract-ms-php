<?php
namespace MsPhp\Entity\Attribute\Prototype\LiteratureSentence;


use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeNumericType;
use MsPhp\Entity\Attribute\ForeignKey;
use MsPhp\Entity\Attribute\Prototype\Literature\TypeId;
use MsPhp\Quality\Entity\QualityBasicNum;
use MsPhp\Quality\Entity\QualityMaxQuantity;
use MsPhp\Quality\Entity\QualityMinQuantity;
use MsPhp\Quality\Entity\QualityMinValue;

class LiteratureId extends AttributeNumericType {
    public function __construct() {
        $foreignKey = (new ForeignKey())
            ->setReference(new TypeId())
            ->setMatch(ForeignKey::MATCH_SIMPLE)
            ->setOnUpdateAction(ForeignKey::ACTION_CASCADE)
            ->setOnDeleteAction(ForeignKey::ACTION_CASCADE);
        $this->setName('literature_id')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_INT)
            ->setDefaultValue(null)
            ->setIsUnique(false)
            ->setIsMultiplePrimaryKey(true)
            ->setForeignKey($foreignKey)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMaxQuantity())->setShallValue(1))
            ->addQuality((new QualityMinValue())->setShallValue(1))
            ->addQuality(new QualityBasicNum());
    }
}
