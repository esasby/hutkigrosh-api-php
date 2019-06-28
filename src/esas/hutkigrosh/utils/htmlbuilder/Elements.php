<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 05.03.2019
 * Time: 13:08
 */

namespace esas\hutkigrosh\utils\htmlbuilder;

use Cardinity\Exception\NotAcceptable;

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
    const IMG = "img";
    const AREA = "area";
    const BASE = "base";
    const LINK = "link";
    const META = "meta";
    const PARAM = "param";
    const COL = "col";
    const A = "a";
    const BR = "br";
    const HR = "hr";
    const SCRIPT = "script";
    const STYLE = "style";

    public static function div(...$elementAndAttributes)
    {
        return new Element(self::DIV, $elementAndAttributes);
    }

    public static function input(...$attributes)
    {
        return new ElementVoid(self::INPUT, $attributes);
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

    public static function styleFile($fileLocation)
    {
        return new Element(self::STYLE, [new ReadContentFile($fileLocation)]);
    }

    public static function option(...$elementAndAttributes)
    {
        return new Element(self::OPTION, $elementAndAttributes);
    }

    public static function span(...$elementAndAttributes)
    {
        return new Element(self::SPAN, $elementAndAttributes);
    }

    public static function img(...$attributes)
    {
        return new ElementVoid(self::IMG, $attributes);
    }

    public static function link(...$attributes)
    {
        return new ElementVoid(self::LINK, $attributes);
    }

    public static function meta(...$attributes)
    {
        return new ElementVoid(self::META, $attributes);
    }

    public static function param(...$attributes)
    {
        return new ElementVoid(self::PARAM, $attributes);
    }

    public static function area(...$attributes)
    {
        return new ElementVoid(self::AREA, $attributes);
    }

    public static function base(...$attributes)
    {
        return new ElementVoid(self::BASE, $attributes);
    }

    public static function col(...$attributes)
    {
        return new ElementVoid(self::COL, $attributes);
    }

    public static function a(...$elementAndAttributes)
    {
        return new Element(self::A, $elementAndAttributes);
    }

    public static function br()
    {
        return new ElementVoid(self::BR, null);
    }

    public static function hr()
    {
        return new ElementVoid(self::HR, null);
    }

    public static function content(...$elementsAndContent)
    {
        return new Content($elementsAndContent);
    }

    public static function includeFile($scriptFileLocation, $scriptData)
    {
        return new IncludeFile($scriptFileLocation, $scriptData);
    }

    public static function includeFileWithCurrentScope($includeFileLocation, $context)
    {
        return new IncludeFile($includeFileLocation, $context);
    }

    public static function includeFileNoData($includeFileLocation)
    {
        return new IncludeFile($includeFileLocation, null);
    }
}