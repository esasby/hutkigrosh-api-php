<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 05.03.2019
 * Time: 13:08
 */

namespace esas\hutkigrosh\utils\htmlbuilder;


class Attributes
{
    const ID = "id";
    const CLAZZ = "class";
    const TYPE = "type";
    const NAME = "name";
    const FORR = "name";
    const PLACEHOLDER = "placeholder";
    const ROWS = "rows";
    const COLS = "cols";
    const VALUE = "value";
    const CHECKED = "checked";
    const SELECTED = "selected";

    /**
     * @param $id
     * @return Attribute
     */
    public static function id($id)
    {
        return new Attribute(self::ID, $id);
    }

    public static function clazz($class)
    {
        return new Attribute(self::CLAZZ, $class);
    }

    public static function type($type)
    {
        return new Attribute(self::TYPE, $type);
    }

    public static function name($name)
    {
        return new Attribute(self::NAME, $name);
    }

    public static function placeholder($nplaceholderme)
    {
        return new Attribute(self::PLACEHOLDER, $nplaceholderme);
    }

    public static function rows($rows)
    {
        return new Attribute(self::PLACEHOLDER, $rows);
    }

    public static function cols($cols)
    {
        return new Attribute(self::PLACEHOLDER, $cols);
    }

    public static function forr($forr)
    {
        return new Attribute(self::FORR, $forr);
    }

    public static function value($value)
    {
        return new Attribute(self::VALUE, $value);
    }

    public static function checked($checked)
    {
        return new AttributeBoolean(self::CHECKED, $checked);
    }

    public static function selected($selected)
    {
        return new AttributeBoolean(self::SELECTED, $selected);
    }
}