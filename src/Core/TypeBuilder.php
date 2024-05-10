<?php

namespace MaxGraphQL\Core;

use MaxGraphQL\Interfaces\FieldType;

abstract class TypeBuilder
{
    /**
     * @return string
     */
    protected function convert()
    {
        $str = $this->getType() . '{' . $this->getName();

        if (!empty($this->getArguments())) {
            $str .= '(' . $this->convertArguments() . ')';
        }

        $str .= '{';
        $str .= $this->convertSelect();
        $str .= '}}';

        return $str;
    }

    private function convertSelect()
    {
        $str = '';

        foreach ($this->getSelect() as $index => $item) {
            if (is_array($item)) {
                $str .= $index . '{';
                $str .= $this->disArraySelect($item);
                $str .= '},';
            } else {
                $str .= $item . ',';
            }
        }

        return substr_replace($str ,'', -1);
    }

    private function convertArguments()
    {
        $str = '';

        foreach ($this->getArguments() as $index => $value) {
            $str .= $index . ':';

            if (is_array($value)) {
                $str .= $this->disArrayArguments($value);
            } else {
                $str .= $this->checkArgumentsString($value);
            }
        }

        return substr_replace($str ,'', -1);
    }

    private function checkArgumentsString($string)
    {
        $str = '';

        if (is_int($string) || is_float($string)) {
            $str .= $string;
        } elseif (is_bool($string)) {
            $str .= $string ? 'true' : 'false';
        } elseif (is_object($string) && is_subclass_of($string, FieldType::class)) {
            $str .= $string->getValue();
        } elseif (is_null($string)) {
            $str .= 'null';
        } else {
            $str .= '"' . $string . '"';
        }

        return $str . ',';
    }

    private function disArraySelect($array)
    {
        $str = '';

        foreach ($array as $index => $value) {
            if (is_array($value)) {
                $str .= $index . '{' . $this->disArraySelect($value) . '},';
            } else {
                $str .= $value . ',';
            }
        }

        return substr_replace($str ,'', -1);
    }

    private function disArrayArguments($array)
    {
        $str = '';

        if ($this->isArrayAssociative($array)) {
            $str .= '{';
        } else {
            $str .= '[';
        }

        foreach ($array as $index => $value) {
            if (is_string($index)) {
                $str .= $index . ':';
            }

            if (is_array($value)) {
                $str .= $this->disArrayArguments($value);
            } else {
                $str .= $this->checkArgumentsString($value);
            }
        }

        $str = substr_replace($str ,'', -1);

        if ($this->isArrayAssociative($array)) {
            $str .= '},';
        } else {
            $str .= '],';
        }

        return $str;
    }

    private function isArrayAssociative($array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * @param $field
     * @return bool
     */
    protected function isDuplicate($field)
    {
        foreach ($this->getSelect() as $item) {
            if ($item === $field) {
                return true;
            }
        }

        return false;
    }
}