<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 10:29
 */

namespace esas\hutkigrosh\view\admin\fields;


use esas\hutkigrosh\view\admin\validators\Validator;

class ConfigFieldNumber extends ConfigField
{
    private $min;
    private $max;

    /**
     * ConfigFieldNumber constructor.
     * @param $min
     * @param $max
     */
    public function __construct($key, $name = null, $description = null, $required = false, Validator $validator = null, $min = 0, $max = 0)
    {
        parent::__construct($key, $name, $description, $required, $validator);
        $this->min = $min;
        $this->max = $max;
    }


    /**
     * @return mixed
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param mixed $min
     * @return ConfigFieldNumber
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param mixed $max
     * @return ConfigFieldNumber
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }
}