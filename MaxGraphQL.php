<?php

namespace MaxGraphQL;

class MutationBuilder
{
    public static function convert($name, $select, $arguments)
    {
        $str = '';

        $str .= 'mutation{' . $name . '(' . self::convertArguments($arguments) . '){';
        $str .= self::convertSelect($select);
        $str .= '}}';

        return $str;
    }

    private static function convertSelect($array)
    {
        $str = '';

        foreach ($array as $index => $item) {
            if (is_array($item)) {
                $str .= $index . '{';
                $str .= self::disArraySelect($item);
                $str .= '},';
            } else {
                $str .= $item . ',';
            }
        }

        return substr_replace($str ,'', -1);
    }

    private static function convertArguments($array)
    {
        $str = '';

        foreach ($array as $index => $value) {
            $str .= $index . ':';

            if (is_array($value)) {
                $str .= self::disArrayArguments($value);
            } else {
                $str .= self::checkArgumentsString($value);
            }
        }

        return substr_replace($str ,'', -1);
    }

    private static function checkArgumentsString($string)
    {
        $str = '';

        if (is_int($string) || is_float($string)) {
            $str .= $string . ',';
        } elseif (is_bool($string)) {
            $str .= $string ? 'true' : 'false' . ',';
        } elseif (ctype_upper($string)) {
            $str .= $string . ',';
        } else {
            $str .= '"' . $string .'",';
        }

        return $str;
    }

    private static function disArraySelect($array)
    {
        $str = '';

        foreach ($array as $index => $value) {
            if (is_array($value)) {
                $str .= $index . '{' . self::disArraySelect($value) . '},';
            } else {
                $str .= $value . ',';
            }
        }

        $str = substr_replace($str ,'', -1);

        return $str;
    }

    private static function disArrayArguments($array)
    {
        $str = '';

        if (self::arrayAssociative($array)) {
            $str .= '{';
        } else {
            $str .= '[';
        }

        foreach ($array as $index => $value) {
            if (is_string($index)) {
                $str .= $index . ':';
            }

            if (is_array($value)) {
                $str .= self::disArrayArguments($value);
            } else {
                $str .= self::checkArgumentsString($value);
            }
        }

        $str = substr_replace($str ,'', -1);

        if (self::arrayAssociative($array)) {
            $str .= '},';
        } else {
            $str .= '],';
        }

        return $str;
    }

    private static function arrayAssociative($array) {
        if (array_keys($array) !== range(0, count($array) - 1)) {
            return true;
        } else {
            return false;
        }
    }
}