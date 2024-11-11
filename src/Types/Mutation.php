<?php

namespace MaxGraphQL\Types;

use MaxGraphQL\Core\TypeBuilder;
use MaxGraphQL\Interfaces\Type;

class Mutation extends TypeBuilder implements Type
{
    const TYPE = 'mutation';
    private $name = '';
    private $select = [];
    private $arguments = [];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->convert();
    }

    /**
     * @param string|array $field
     * @return self
     */
    public function addSelect($field)
    {
        if (is_array($field)) {
            foreach ($field as $index => $item) {
                if (!$this->isDuplicate($item, $index)) {
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

    /**
     * @return string
     */
    public function getPreparedQuery()
    {
        return $this->convert();
    }

    /**
     * @param string $name
     * @param string|array $select
     * @param array $arguments
     * @return string
     */
    public static function getPreparedQueryFrom($name, $select, $arguments = [])
    {
        return (new self($name))->addSelect($select)->addArguments($arguments)->convert();
    }

    /**
     * @param array $arguments
     * @return self
     */
    public function addArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @return array
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}