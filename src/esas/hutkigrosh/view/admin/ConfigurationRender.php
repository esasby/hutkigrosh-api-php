<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 30.09.2018
 * Time: 15:15
 */

namespace esas\hutkigrosh\view\admin;


use esas\hutkigrosh\ConfigurationFields;

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
abstract class ConfigurationRender
{
    /**
     * @var ConfigField[]
     */
    private $fields;

    /**
     * @var ConfigField[]
     */
    private $allFields;

    /**
     * ConfigurationRender constructor.
     */
    public function __construct()
    {
        $this->allFields[] = new ConfigFieldText(ConfigurationFields::SHOP_NAME, null, null, true);
        $this->allFields[] = new ConfigFieldText(ConfigurationFields::LOGIN, null, null, true);
        $this->allFields[] = new ConfigFieldPassword(ConfigurationFields::PASSWORD, null, null, true);
        $this->allFields[] = new ConfigFieldNumber(ConfigurationFields::ERIP_ID, null, null, true, 10000000, 99999999);
        $this->allFields[] = new ConfigFieldCheckbox(ConfigurationFields::SANDBOX, null, null, true);
        $this->allFields[] = new ConfigFieldCheckbox(ConfigurationFields::ALFACLICK_BUTTON, null, null, true);
        $this->allFields[] = new ConfigFieldCheckbox(ConfigurationFields::WEBPAY_BUTTON, null, null, true);
        $this->allFields[] = new ConfigFieldCheckbox(ConfigurationFields::EMAIL_NOTIFICATION, null, null, true);
        $this->allFields[] = new ConfigFieldCheckbox(ConfigurationFields::SMS_NOTIFICATION, null, null, true);
        $this->allFields[] = new ConfigFieldText(ConfigurationFields::ERIP_PATH, null, null, true);
        $this->allFields[] = new ConfigFieldNumber(ConfigurationFields::DUE_INTERVAL, null, null, true, 1, 10);
        $this->allFields[] = new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_PENDING, null, null, true);
        $this->allFields[] = new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_PAYED, null, null, true);
        $this->allFields[] = new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_FAILED, null, null, true);
        $this->allFields[] = new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_CANCELED, null, null, true);
        $this->allFields[] = new ConfigFieldTextarea(ConfigurationFields::COMPLETION_TEXT, null, null, true);
        $this->allFields[] = new ConfigFieldText(ConfigurationFields::PAYMENT_METHOD_NAME, null, null, true);
        $this->allFields[] = new ConfigFieldText(ConfigurationFields::PAYMENT_METHOD_DETAILS, null, null, true);
    }


    public function addRequired()
    {
        $this->addAllExcept([
            ConfigurationFields::SHOP_NAME,
            ConfigurationFields::COMPLETION_TEXT,
            ConfigurationFields::PAYMENT_METHOD_NAME,
            ConfigurationFields::PAYMENT_METHOD_DETAILS]);
    }

    /**
     * Добавление всех стандартных полей
     */
    public function addAll()
    {
        unset($this->fields);
        $this->fields = $this->allFields;
    }

    /**
     * Добавление всех стандартных полей
     */
    public function addAllExcept(array $exclude)
    {
        unset($this->fields);
        foreach ($this->allFields as $configField) {
            if (!in_array($configField->getKey(), $exclude)) {
                $this->fields[] = $configField;
            }
        }
    }

    public function addField(ConfigField $configField)
    {
        $this->fields[] = $configField;
    }

    public function render()
    {
        foreach ($this->fields as $configField) {
            if ($configField instanceof ConfigFieldPassword)
                return $this->renderPasswordField($configField);
            elseif ($configField instanceof ConfigFieldNumber)
                return $this->renderNumberField($configField);
            elseif ($configField instanceof ConfigFieldCheckbox)
                return $this->renderCheckboxField($configField);
            elseif ($configField instanceof ConfigFieldList)
                return $this->renderListField($configField);
            elseif ($configField instanceof ConfigFieldStatusList)
                return $this->renderStatusListField($configField);
            else
                return $this->renderTextField($configField);
        }
    }

    abstract function renderTextField(ConfigField $configField);

    public function renderNumberField(ConfigFieldNumber $configField)
    {
        return $this->renderTextField($configField);
    }

    public function renderPasswordField(ConfigFieldPassword $configField)
    {
        return $this->renderTextField($configField);
    }

    public function renderCheckboxField(ConfigFieldCheckbox $configField)
    {
        return $this->renderTextField($configField);
    }

    public function renderStatusListField(ConfigFieldStatusList $configField)
    {
        return $this->renderTextField($configField);
    }

    public function renderListField(ConfigFieldList $configField)
    {
        return $this->renderTextField($configField);
    }

}