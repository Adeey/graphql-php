<?php

namespace MaxGraphQL;

include 'Builder.php';

class Mutation extends Builder
{
    private $name = '';
    private $select = [];
    private $arguments = [];
    private $endpoint;

    public function __construct($url, $name)
    {
        $this->name = $name;
        $this->endpoint = $url;
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
        return self::convert($this->name, $this->select, $this->arguments);
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

    public function getUrl()
    {
        return $this->endpoint;
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