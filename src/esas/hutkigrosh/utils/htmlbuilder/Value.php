<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 05.03.2019
 * Time: 14:42
 */

namespace esas\hutkigrosh\utils\htmlbuilder;


class Value
{
    private $value;

    /**
     * Value constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return strval($this->value);
    }
}