<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 11.10.2018
 * Time: 13:29
 */

namespace esas\hutkigrosh\view\admin\validators;


class ValidatorNotEmpty extends Validator
{
    /**
     * @return boolean
     */
    public function validateValue($value)
    {
        return $value != null && $value != "";
    }
}