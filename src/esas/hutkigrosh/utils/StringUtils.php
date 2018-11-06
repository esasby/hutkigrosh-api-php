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

}