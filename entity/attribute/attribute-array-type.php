<?php

namespace MsPhp\Entity\Attribute;

abstract class AttributeArrayType extends AttributeCharacterType {
    const VALUE_TYPE_ARRAY_SMALLINT = 'smallint[]';
    const VALUE_TYPE_ARRAY_INTEGER = 'integer[]';
    const VALUE_TYPE_ARRAY_BIGINT = 'bigint[]';
    const VALUE_TYPE_ARRAY_VARCHAR = 'varchar[]';
    const VALUE_TYPE_ARRAY_TEXT = 'text[]';
}
