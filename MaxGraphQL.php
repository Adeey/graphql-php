<?php

namespace MaxGraphQL;

class MutationBuilder
{
    public static function convert($array)
    {
        $str = '';

        foreach ($array as $index => $value) {
            $str .= $index . ':';

            if (is_array($value)) {
                $str .= self::disArray($value);
            } else {
                $str .= self::checkString($value);
            }
        }

        return substr_replace($str ,'', -1);
    }

    private static function checkString($string)
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

    private static function disArray($array)
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
                $str .= self::disArray($value);
            } else {
                $str .= self::checkString($value);
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