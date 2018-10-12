<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 30.09.2018
 * Time: 15:07
 */

namespace esas\hutkigrosh\view\admin\fields;


use esas\hutkigrosh\Registry;
use esas\hutkigrosh\view\admin\validators\Validator;
use esas\hutkigrosh\view\admin\validators\ValidatorImpl;

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
     * @var Validator
     */
    private $validator;
    

    /**
     * ConfigField constructor.
     * @param string $key
     * @param string $name
     * @param string $description
     * @param bool $required
     * @param string $type
     */
    public function __construct($key, $name = null, $description = null, $required = false, Validator $validator = null)
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
        if ($validator != null)
            $this->validator = $validator;
        else
            $this->validator = new ValidatorImpl("");
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
     * Возвращает значения настройки из хранилища или текущее, значение указаное администратором перед сохранением 
     * (чтобы в случае ошибки в каком-либо поле, администратору не пришлось повторно вводить все поля)
     * @return mixed
     */
    public function getValue()
    {
        //тут будет не null, если до этого для поля вызывался валидатор
        if (!is_null($this->validator->getValidatedValue()))
            return $this->validator->getValidatedValue();
        else
            return Registry::getRegistry()->getConfigurationWrapper()->get($this->key);
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param Validator $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }
    
}