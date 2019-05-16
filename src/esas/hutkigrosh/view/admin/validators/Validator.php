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
use Exception;
use Throwable;

/**
 * Class Validator используется для проверки корректности введенных значений
 * @package esas\hutkigrosh\view\admin\validators
 */
abstract class Validator
{
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
    }


    /**
     * @param $value
     * @return ValidationResult
     */
    public function validate($value)
    {
        $ret = new ValidationResult();
        $ret->setValidatedValue($value);
        try {
            $ret->setValid($this->validateValue($value));
        } catch (Throwable $e) {
            $ret->setValid(false);
        } catch (Exception $e) { // для совместимости с php 5
            $ret->setValid(false);
        }
        if (!$ret->isValid()) {
            $ret->setErrorTextSimple($this->errorText);
        }
        return $ret;
    }

    /**
     * @return boolean
     */
    public abstract function validateValue($value);
}