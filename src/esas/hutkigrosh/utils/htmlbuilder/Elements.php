<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 05.03.2019
 * Time: 13:08
 */

namespace esas\hutkigrosh\utils\htmlbuilder;


use esas\hutkigrosh\utils\htmlbuilder\Div;

class Elements
{
    const DIV = "div";
    const INPUT = "input";
    const TEXTAREA = "textarea";
    const LABEL = "label";
    const SELECT = "select";
    const VALUE = "value";
    const OPTION = "option";
    const SPAN = "span";

    public static function div(...$elementAndAttributes)
    {
        return new Element(self::DIV, $elementAndAttributes);
    }

    public static function input(...$elementAndAttributes)
    {
        return new Element(self::INPUT, $elementAndAttributes);
    }

    public static function select(...$elementAndAttributes)
    {
        return new Element(self::SELECT, $elementAndAttributes);
    }

    public static function textarea(...$elementAndAttributes)
    {
        return new Element(self::TEXTAREA, $elementAndAttributes);
    }

    public static function label(...$elementAndAttributes)
    {
        return new Element(self::LABEL, $elementAndAttributes);
    }

    public static function option(...$elementAndAttributes)
    {
        return new Element(self::OPTION, $elementAndAttributes);
    }

    public static function span(...$elementAndAttributes)
    {
        return new Element(self::SPAN, $elementAndAttributes);
    }

    public static function value($value)
    {
        return new Value($value);
    }


}