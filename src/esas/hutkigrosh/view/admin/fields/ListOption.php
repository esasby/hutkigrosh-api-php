<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 13:35
 */

namespace esas\hutkigrosh\view\admin\fields;


class ListOption
{
    private $value;

    private $name;

    /**
     * ListOption constructor.
     * @param $value
     * @param $name
     */
    public function __construct($value, $name)
    {
        $this->value = $value;
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}