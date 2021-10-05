<?php
namespace MsPhp\Entity\Attribute\Prototype\Common;


use MsPhp\App\Process\Access;
use MsPhp\Conversion\Entity\ConversionUnderscore;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Quality\Entity\QualityBadLanguage;
use MsPhp\Quality\Entity\QualityMinQuantity;

abstract class Type extends AttributeCharacterType {
    public function __construct() {
        $path = explode('\\', get_class($this));
        $name = array_pop($path);
        $conversion = (new ConversionUnderscore())
            ->setString($name)
            ->setResult();
        $this->setName($conversion->getResult())
            ->setIdValueType(self::ID_VALUE_TYPE_SMALLSERIAL)
            ->setAccessType(Access::TYPE_PUBLIC)
            ->setValueType(self::VALUE_TYPE_VARCHAR)
            ->setDefaultValue(null)
            ->setIsUnique(true)
            ->setIsMultiplePrimaryKey(false)
            ->addQuality((new QualityMinQuantity())->setShallValue(1))
            ->addQuality(new QualityBadLanguage());
    }
}
