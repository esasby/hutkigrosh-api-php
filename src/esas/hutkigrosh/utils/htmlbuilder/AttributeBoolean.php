<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 05.03.2019
 * Time: 16:17
 */

namespace esas\hutkigrosh\utils\htmlbuilder;

/**
 * Class AttributeBoolean для аттрибутов, для которых не указываются значения
 * http://w3c.github.io/html/infrastructure.html#sec-boolean-attributes
 * @package esas\hutkigrosh\utils\htmlbuilder
 */
class AttributeBoolean extends Attribute
{
    public function __toString()
    {
        if ($this->value) {
            return $this->name;
        } else
            return "";
    }
}