<?php

namespace MaxGraphQL\FieldTypes;

use MaxGraphQL\Interfaces\FieldType;

class Enum implements FieldType
{
    /** @var string $value */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}