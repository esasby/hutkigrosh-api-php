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
    const ALIGN = "align";
    const TYPE = "type";
    const NAME = "name";
    const FORR = "for";
    const PLACEHOLDER = "placeholder";
    const ROWS = "rows";
    const COLS = "cols";
    const VALUE = "value";
    const CHECKED = "checked";
    const SELECTED = "selected";
    const DATA_TOGLE = "data-toggle";
    const TITLE = "title";
    const SRC = "src";
    const ALT = "alt";
    const HREF = "href";
    const MAXLENGTH = "maxlength";

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

    public static function align($align)
    {
        return new Attribute(self::ALIGN, $align);
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
        return new Attribute(self::ROWS, $rows);
    }

    public static function cols($cols)
    {
        return new Attribute(self::COLS, $cols);
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

    public static function data_toggle($dataToggle)
    {
        return new Attribute(self::DATA_TOGLE, $dataToggle);
    }

    public static function title($title)
    {
        return new Attribute(self::TITLE, $title);
    }

    public static function src($src)
    {
        return new Attribute(self::SRC, $src);
    }

    public static function alt($alt)
    {
        return new Attribute(self::ALT, $alt);
    }

    public static function href($href)
    {
        return new Attribute(self::HREF, $href);
    }

    public static function maxlength($maxlength)
    {
        return new Attribute(self::MAXLENGTH, $maxlength);
    }
}