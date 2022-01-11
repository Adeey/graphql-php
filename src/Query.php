<?php

namespace MaxGraphQL;

class Query extends Builder
{
    private $name = '';
    const TYPE = 'query';
    private $select = [];
    private $arguments = [];

    public function __construct($name)
    {
        $this->name = $name;
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
    }

    public function getPreparedQuery()
    {
        return self::convert($this->name, $this->select, $this->arguments, self::TYPE);
    }

    public static function getPreparedQueryFrom($name, $select, $arguments = [])
    {
        return self::convert($name, $select, $arguments, self::TYPE);
    }

    public function addArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    public function getSelect()
    {
        return $this->select;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    private function isDuplicate($field)
    {
        foreach ($this->select as $item) {
            if ($item === $field) {
                return true;
            }
        }

        return false;
    }
}