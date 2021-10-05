<?php

namespace MsPhp\Entity\Attribute;

use MsPhp\App\Process\Access;
use MsPhp\Quality\Entity\QualityAllowedValue;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMaxQuantity;
use MsPhp\Quality\Entity\QualityMinQuantity;

class AttributeBooleanType extends Attribute {
    const VALUE_TYPE_BOOLEAN = 'boolean';
    protected string $options = [
        'f' => 'no',
        't' => 'yes',
    ];
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    /*public function __construct() {
        $this->setName('gender_id')
            ->setIdValueType(self::ID_VALUE_TYPE_INT)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_BOOLEAN)
            ->setDefaultValue(null)
            ->setIsUnique(false)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality((new QualityMaxQuantity())->setShallValue(1))
            ->addQuality((new QualityMaxLength())->setShallValue(1))
            ->addQuality((new QualityAllowedValue())->setShallValue(['t','f']));
    }*/
}
