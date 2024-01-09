<?php

namespace MaxGraphQL\Interfaces;

interface FieldType
{
    /**
     * @return string
     */
    public function getValue();
}