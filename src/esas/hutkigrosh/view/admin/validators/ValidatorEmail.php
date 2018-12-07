<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 07.12.2018
 * Time: 11:55
 */

namespace esas\hutkigrosh\view\admin\validators;


class ValidatorEmail extends Validator
{

    /**
     * @return boolean
     */
    public function validateValue($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}