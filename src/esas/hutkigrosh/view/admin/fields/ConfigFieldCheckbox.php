<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 10:29
 */

namespace esas\hutkigrosh\view\admin\fields;


class ConfigFieldCheckbox extends ConfigField
{
    /**
     * Метод для повышения читабельности. Конвертация в boolean выполняется в ConfigurationWrapper.convertToBoolean
     * @return boolean
     */
    public function isChecked()
    {
        return $this->getValue();
    }

}