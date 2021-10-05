<?php

namespace MsPhp\Entity\Attribute;

abstract class AttributeDatetimeType extends AttributeCharacterType {
    const VALUE_TYPE_DATE = 'date';
    const VALUE_TYPE_TIME = 'time';
    const VALUE_TYPE_TIMESTAMP = 'timestamp';
    const VALUE_TYPE_INTERVAL = 'interval';
}
