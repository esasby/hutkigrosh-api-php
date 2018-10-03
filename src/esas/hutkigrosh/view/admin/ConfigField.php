<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 30.09.2018
 * Time: 15:07
 */

namespace esas\hutkigrosh\view\admin;


use esas\hutkigrosh\Registry;

abstract class ConfigField
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var boolean
     */
    private $required;
    

    /**
     * ConfigField constructor.
     * @param string $key
     * @param string $name
     * @param string $description
     * @param bool $required
     * @param string $type
     */
    public function __construct($key, $name = null, $description = null, $required = false)
    {
        $this->key = $key;
        if ($name != null)
            $this->name = $name;
        else
            $this->name = Registry::getRegistry()->getTranslator()->getConfigFieldName($key);
        if ($description != null)
            $this->description = $description;
        else
            $this->description= Registry::getRegistry()->getTranslator()->getConfigFieldDescription($key);
        $this->required = $required;
    }


    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param bool $required
     */
    public function setRequired($required)
    {
        $this->required = $required;
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
    
    
}