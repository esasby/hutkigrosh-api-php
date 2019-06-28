<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 06.03.2019
 * Time: 11:02
 */

namespace esas\hutkigrosh\utils;


class ArrayUtils
{
    /**
     * Преобразует многомерный массив в плоский
     * @param array $array
     * @return array
     */
    public static function flatten(array $array)
    {
        $return = array();
        array_walk_recursive($array, function ($a) use (&$return) {
            $return[] = $a;
        });
        return $return;
    }

    public static function safeImplode($glue, $objects)
    {
        if ($objects == null)
            return "";

        if (is_array($objects)) {
            $objects = self::flatten($objects);
            return implode($glue, $objects);
        } else
            return $objects->__toString();

    }
}