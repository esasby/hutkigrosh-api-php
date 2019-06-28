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
     * Element constructor.
     * @param $name
     * @param array $attibutesAndElements
     */
    public function __construct($name, array $attibutesAndElements)
    {
        $this->name = $name;
        $this->add($attibutesAndElements);
    }

    public function add(...$attibutesAndElements) {
        $attibutesAndElements = ArrayUtils::flatten($attibutesAndElements);
        foreach ($attibutesAndElements as $obj) {
            if ($obj instanceof Attribute)
                $this->attibutes[] = $obj;
            else
                $this->children[] = $obj;
        }
    }

    public function __toString()
    {
        return StringUtils::format('<%elementName %attributes>%children</%elementName>', [
            "%elementName" => $this->name,
            "%attributes" => ArrayUtils::safeImplode(" ", $this->attibutes),
            "%children" => ArrayUtils::safeImplode(" ", $this->children)
        ]);
    }

}