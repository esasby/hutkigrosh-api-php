<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 30.09.2018
 * Time: 15:07
 */

namespace esas\hutkigrosh\view\admin\fields;


use esas\hutkigrosh\Registry;
use esas\hutkigrosh\view\admin\validators\ValidationResult;
use esas\hutkigrosh\view\admin\validators\Validator;
use esas\hutkigrosh\view\admin\validators\ValidatorImpl;

/**
 * Class ConfigField используется для представления в админке поля с настройкой плагина.
 * Доступ к значениям выполняется через ConfigurationWrapper
 * @package esas\hutkigrosh\view\admin\fields
 */
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
     * @var mixed
     */
    private $default = null;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var ValidationResult
     */
    private $validationResult;

    /**
     * @var int
     */
    private $sortOrder;


    /**
     * ConfigField constructor.
     * @param string $key
     * @param string $name
     * @param string $description
     * @param bool $required
     * @return ConfigField
     */
    public function __construct($key, $name = null, $description = null, $required = false, Validator $validator = null)
    {
        $this->setKey($key);
        if ($name != null)
            $this->name = $name;
        else
            $this->name = Registry::getRegistry()->getTranslator()->getConfigFieldName($key);
        if ($description != null)
            $this->description = $description;
        else
            $this->description = Registry::getRegistry()->getTranslator()->getConfigFieldDescription($key);
        $this->required = $required;
        if ($validator != null)
            $this->validator = $validator;
        else
            $this->validator = new ValidatorImpl("");
        $this->default = Registry::getRegistry()->getConfigurationWrapper()->getDefaultConfig($key);
        return $this;
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
     * @return ConfigField
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
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
     * @return ConfigField
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
     * @return ConfigField
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
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
     * @return ConfigField
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * Возвращает значения настройки из хранилища или текущее, значение указаное администратором перед сохранением
     * (чтобы в случае ошибки в каком-либо поле, администратору не пришлось повторно вводить все поля)
     * @return mixed
     */
    public function getValue()
    {
        //тут будет не null, если до этого для поля вызывался валидатор
        if (!is_null($this->validationResult))
            return $this->validationResult->getValidatedValue();
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
     * @return ConfigField
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
        return $this;
    }


    /**
     * @param $value
     * @return ValidationResult
     */
    public function validate($value)
    {
        $this->validationResult = $this->validator->validate($value);
        $this->validationResult->setErrorTextFull("Поле '" . $this->getName() . "': " . $this->validationResult->getErrorTextSimple());
        return $this->validationResult;
    }

    /**
     * @return ValidationResult
     */
    public function getValidationResult()
    {
        return $this->validationResult;
    }

    /**
     * @param ValidationResult $validationResult
     */
    public function setValidationResult($validationResult)
    {
        $this->validationResult = $validationResult;
    }


    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     * @return ConfigField
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasDefault()
    {
        return $this->default != null;
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param int $sortOrder
     * @return ConfigField
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

}