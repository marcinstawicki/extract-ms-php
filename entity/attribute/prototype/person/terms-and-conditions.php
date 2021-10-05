<?php
namespace MsPhp\Entity\Attribute\Prototype\Person;

use MsPhp\App\Process\Access;
use MsPhp\Entity\Attribute\AttributeBooleanType;
use MsPhp\Quality\Entity\QualityMaxQuantity;
use MsPhp\Quality\Entity\QualityMinQuantity;

class TermsAndConditions extends AttributeBooleanType {
    public function __construct() {
       $this->setName('are_terms_and_conditions')
           ->setIdValueType(self::ID_VALUE_TYPE_INT)
           ->setAccessType(Access::TYPE_PUBLIC)
           ->setValueType(self::VALUE_TYPE_BOOLEAN)
           ->setDefaultValue(null)
           ->setIsUnique(false)
           ->setIsMultiplePrimaryKey(false)
           ->setOptions(['I do not accept the terms and conditions.','I have read the terms and conditions and I accept them.'])
           ->addQuality((new QualityMinQuantity())->setShallValue(1))
           ->addQuality((new QualityMaxQuantity())->setVisibility(QualityMaxQuantity::VISIBILITY_PROTECTED)->setShallValue(1));
    }
}
