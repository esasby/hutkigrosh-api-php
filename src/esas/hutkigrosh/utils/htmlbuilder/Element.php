<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 05.03.2019
 * Time: 13:13
 */

namespace esas\hutkigrosh\utils\htmlbuilder;


use esas\hutkigrosh\utils\ArrayUtils;
use esas\hutkigrosh\utils\Logger;
use esas\hutkigrosh\utils\StringUtils;

class Element
{
    private $name;
    /**
     * @return Attribute[]
     */
    private $attibutes;
    /**
     * @return Element[]
     */
    private $children;

    /**
     * @return Value[]
     */
    private $values;

    /**
     * Element constructor.
     * @param $name
     * @param array $attibutesAndElements
     */
    public function __construct($name, array $attibutesAndElements)
    {
        $this->name = $name;
        $attibutesAndElements = ArrayUtils::flatten($attibutesAndElements);
        foreach ($attibutesAndElements as $obj) {
            if ($obj instanceof Element)
                $this->children[] = $obj;
            elseif ($obj instanceof Attribute)
                $this->attibutes[] = $obj;
            elseif ($obj instanceof Value)
                $this->values[] = $obj;

            else
                Logger::getLogger("Unknown htmlbuilder arg");
        }
    }

    public function __toString()
    {
        return StringUtils::format('<%elementName %attributes>%children%value</%elementName>', [
            "%elementName" => $this->name,
            "%attributes" => self::safeImplode(" ", $this->attibutes),
            "%children" => self::safeImplode(" ", $this->children),
            "%value" => self::safeImplode(" ", $this->values)
        ]);
    }

    public static function safeImplode($glue, $objects)
    {
        if ($objects == null)
            return "";

        if (is_array($objects)) {
            $objects = ArrayUtils::flatten($objects);
            return implode($glue, $objects);
        } else
            return $objects->__toString();

    }


    /**
     * @return string
     */
    public function renderAttributes()
    {
        $ret = "";
        foreach ($this->attibutes as $attibute) {
            $ret .= $attibute;
        }
        return $ret;
    }

    /**
     * @return string
     */
    public function renderChildren()
    {
        $ret = "";
        foreach ($this->children as $element) {
            $ret .= $element;
        }
        return $ret;
    }
}