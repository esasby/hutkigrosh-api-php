<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 24.10.2018
 * Time: 16:42
 */

namespace esas\hutkigrosh\view\admin\validators;


class ValidationResult
{
    private $valid;

    private $validatedValue;

    private $errorTextSimple = "";

    private $errorTextFull = "";

    /**
     * @return mixed
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @param mixed $valid
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
    }

    /**
     * @return mixed
     */
    public function getValidatedValue()
    {
        return $this->validatedValue;
    }

    /**
     * @param mixed $validatedValue
     */
    public function setValidatedValue($validatedValue)
    {
        $this->validatedValue = $validatedValue;
    }

    /**
     * @return string
     */
    public function getErrorTextSimple()
    {
        return $this->errorTextSimple;
    }

    /**
     * @param string $errorTextSimple
     */
    public function setErrorTextSimple($errorTextSimple)
    {
        $this->errorTextSimple = $errorTextSimple;
    }

    /**
     * @return string
     */
    public function getErrorTextFull()
    {
        return $this->errorTextFull;
    }

    /**
     * @param string $errorTextFull
     */
    public function setErrorTextFull($errorTextFull)
    {
        $this->errorTextFull = $errorTextFull;
    }


}