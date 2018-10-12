<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 11.10.2018
 * Time: 12:44
 */

namespace esas\hutkigrosh\view\admin\validators;


use esas\hutkigrosh\lang\Translator;
use esas\hutkigrosh\Registry;
use Throwable;

/**
 * Class Validator используется для проверки корректности введенных значений
 * @package esas\hutkigrosh\view\admin\validators
 */
abstract class Validator
{
    protected $validatedValue;
    protected $isValid;
    protected $errorText;
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * Validator constructor.
     * @param $errorText
     */
    public function __construct($vsprintfArgs = null)
    {
        $this->errorText = Registry::getRegistry()->getTranslator()->getValidationError(get_class($this));
        if ($vsprintfArgs != null)
            $this->errorText = vsprintf($this->errorText, $vsprintfArgs);
        $this->isValid = true;
    }


    /**
     * @return mixed
     */
    public function getValidatedValue()
    {
        return $this->validatedValue;
    }

    /**
     * @return mixed
     */
    public function getErrorText()
    {
        if (!$this->isValid)
            return $this->errorText;
        return "";
    }

    public function isValid()
    {
        return $this->isValid;
    }

    public function validate($value)
    {
        $this->validatedValue = $value;
        try {
            $this->isValid = $this->validateValue($value);
        } catch (Throwable $e) {
            $this->isValid = false;
        }
        return $this->isValid;
    }

    /**
     * @return boolean
     */
    public abstract function validateValue($value);
}