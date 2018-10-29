<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 30.09.2018
 * Time: 15:15
 */

namespace esas\hutkigrosh\view\admin;


use esas\hutkigrosh\ConfigurationFields;
use esas\hutkigrosh\utils\Logger;
use esas\hutkigrosh\view\admin\fields\ConfigField;
use esas\hutkigrosh\view\admin\fields\ConfigFieldTextarea;
use esas\hutkigrosh\view\admin\fields\ConfigFieldText;
use esas\hutkigrosh\view\admin\fields\ConfigFieldPassword;
use esas\hutkigrosh\view\admin\fields\ConfigFieldNumber;
use esas\hutkigrosh\view\admin\fields\ConfigFieldCheckbox;
use esas\hutkigrosh\view\admin\fields\ConfigFieldStatusList;
use esas\hutkigrosh\view\admin\fields\ConfigFieldList;
use esas\hutkigrosh\view\admin\validators\ValidatorInteger;
use esas\hutkigrosh\view\admin\validators\ValidatorNotEmpty;

/**
 * Class ConfigurationRender обеспечивает render (в html) полей для редактирования настроек плагина
 * В плагинах для конкретных CMS должен быть создан наследник и переопределены методы render****Field
 * (минимум должен быть переопределен renderTextField).
 * Пример использования для opencart:
 * $configFieldsRender = new ConfigurationRenderOpencart();
 * $configFieldsRender->addAll();
 * $configFieldsRender->addField(new ConfigFieldNumber <> ); // добавление какого-то особоного поля для CMS 
 * $configFieldsRender->render(); // формирует html
 * @package esas\hutkigrosh\view\admin
 */
abstract class ConfigFormArray extends ConfigForm
{

    /**
     * Производит формирование конечного html с настройками модуля
     * @return array
     */
    public function generate()
    {
        // при проверке instanceof не забывать про наследование
        foreach ($this->fieldsToRender as $configField) {
            if ($configField instanceof ConfigFieldPassword) {
                $ret[$configField->getKey()] = $this->generatePasswordField($configField);
                continue;
            }
            elseif ($configField instanceof ConfigFieldTextarea) {
                $ret[$configField->getKey()] = $this->generateTextAreaField($configField);
                continue;
            }
            elseif ($configField instanceof ConfigFieldNumber) {
                $ret[$configField->getKey()] = $this->generateNumberField($configField);
                continue;
            }
            elseif ($configField instanceof ConfigFieldCheckbox) {
                $ret[$configField->getKey()] = $this->generateCheckboxField($configField);
                continue;
            }
            elseif ($configField instanceof ConfigFieldStatusList) {
                $ret[$configField->getKey()] = $this->generateStatusListField($configField);
                continue;
            }
            elseif ($configField instanceof ConfigFieldList) {
                $ret[$configField->getKey()] = $this->renderListField($configField);
                continue;
            }
            else
                $ret[$configField->getKey()] = $this->generateTextField($configField);
        }
        return $ret;
    }
}