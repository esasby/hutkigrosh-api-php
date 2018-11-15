<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 06.11.2018
 * Time: 16:56
 */

namespace esas\hutkigrosh\utils;


class StringUtils
{
    static function compare($string1, $string2) {
        return strcmp(trim($string1), trim($string2)) == 0;
    }

    static function substrBetween($string, $from, $to) {
        $startIndex = min($from, $to);
        $length = abs($from - $to);
        return substr($string, $startIndex, $length);
    }

    static function substrBefore($string, $to) {
        return self::substrBetween($string, 0, $to);
    }
}