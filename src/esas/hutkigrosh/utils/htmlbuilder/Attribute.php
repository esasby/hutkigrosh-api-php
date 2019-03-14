<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 05.03.2019
 * Time: 13:49
 */

namespace esas\hutkigrosh\utils\htmlbuilder;


class Attribute
{
    protected $name;
    protected $value;

    /**
     * Attribute constructor.
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }


    public function __toString()
    {
        return $this->name . '="' . $this->value . '"';
    }


}