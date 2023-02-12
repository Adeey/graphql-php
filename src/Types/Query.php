<?php

namespace MaxGraphQL\Types;

use MaxGraphQL\Core\TypeBuilder;
use MaxGraphQL\Interfaces\Type;

class Query extends TypeBuilder implements Type
{
    const TYPE = 'query';
    private $name = '';
    private $select = [];
    private $arguments = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->convert();
    }

    public function addSelect($field)
    {
        if (is_array($field)) {
            foreach ($field as $index => $item) {
                if (!$this->isDuplicate($item)) {
                    $this->select[$index] = $item;
                }
            }
        } else {
            if (!$this->isDuplicate($field)) {
                $this->select[] = $field;
            }
        }
        return $this;
    }

    public function getPreparedQuery()
    {
        return $this->convert();
    }

    public static function getPreparedQueryFrom($name, $select, $arguments = [])
    {
        return (new self($name))->addSelect($select)->addArguments($arguments)->getPreparedQuery();
    }

    public function addArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    public function getSelect()
    {
        return $this->select;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function getType()
    {
        return self::TYPE;
    }

    public function getName()
    {
        return $this->name;
    }
}