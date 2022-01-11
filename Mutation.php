<?php

namespace MaxGraphQL;

class Mutation extends MutationBuilder
{
    private $select = [];
    private $arguments = [];
    private $endpoint;

    public function __construct($url)
    {
        $this->endpoint = $url;
    }

    public function addSelect($field)
    {
        if (is_array($field)) {
            foreach ($field as $item) {
                if (!$this->isDuplicate($item)) {
                    $this->select[] = $item;
                }
            }
        } else {
            if (!$this->isDuplicate($field)) {
                $this->select[] = $field;
            }
        }
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

    public function isDuplicate($field)
    {
        foreach ($this->select as $item) {
            if ($item === $field) {
                return true;
            }
        }

        return false;
    }
}