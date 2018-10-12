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
abstract class ConfigurationRender
{
    /**
     * Массив настроек, которые должны быть отображены для конкретного модуля
     * @var ConfigField[]
     */
    private $fieldsToRender;

    /**
     * Массив для хранения всех возможнах настроек модуля
     * @var ConfigField[]
     */
    private $allFields;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Общий итоговый текст, содержащий все ошибки валидации
     * @var string
     */
    private $validationErrorText;

    /**
     * ConfigurationRender constructor.
     */
    public function __construct()
    {
        $this->logger = Logger::getLogger(get_class($this));
        $this->registerField(new ConfigFieldText(ConfigurationFields::SHOP_NAME, null, null, true));
        $this->registerField(new ConfigFieldText(ConfigurationFields::LOGIN, null, null, true, new ValidatorNotEmpty()));
        $this->registerField(new ConfigFieldPassword(ConfigurationFields::PASSWORD, null, null, true, new ValidatorNotEmpty()));
        $this->registerField(new ConfigFieldNumber(ConfigurationFields::ERIP_ID, null, null, true, new ValidatorInteger(10000000, 99999999), 10000000, 9999999));
        $this->registerField(new ConfigFieldCheckbox(ConfigurationFields::SANDBOX, null, null, false));
        $this->registerField(new ConfigFieldCheckbox(ConfigurationFields::EMAIL_NOTIFICATION, null, null, false));
        $this->registerField(new ConfigFieldCheckbox(ConfigurationFields::SMS_NOTIFICATION, null, null, false));
        $this->registerField(new ConfigFieldText(ConfigurationFields::ERIP_PATH, null, null, true, new ValidatorNotEmpty()));
        $this->registerField(new ConfigFieldNumber(ConfigurationFields::DUE_INTERVAL, null, null, false, new ValidatorInteger(1, 10), 1, 10));
        $this->registerField(new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_PENDING, null, null, true));
        $this->registerField(new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_PAYED, null, null, true));
        $this->registerField(new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_FAILED, null, null, true));
        $this->registerField(new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_CANCELED, null, null, true));
        $this->registerField(new ConfigFieldCheckbox(ConfigurationFields::ALFACLICK_BUTTON, null, null, false));
        $this->registerField(new ConfigFieldCheckbox(ConfigurationFields::WEBPAY_BUTTON, null, null, false));
        $this->registerField(new ConfigFieldTextarea(ConfigurationFields::COMPLETION_TEXT, null, null, true));
        $this->registerField(new ConfigFieldText(ConfigurationFields::PAYMENT_METHOD_NAME, null, null, true, new ValidatorNotEmpty()));
        $this->registerField(new ConfigFieldText(ConfigurationFields::PAYMENT_METHOD_DETAILS, null, null, false, new ValidatorNotEmpty()));
    }

    /**
     * Внутренний метод для заполнения массива всез настроек
     * @param ConfigField $configField
     */
    private function registerField(ConfigField $configField) {
        $this->allFields[$configField->getKey()] = $configField;
    }


    /**
     * Добавляет для рендеринга только обязательные поля, без которых плагин работать не будет
     */
    public function addRequired()
    {
        $this->addAllExcept([
            ConfigurationFields::SHOP_NAME,
            ConfigurationFields::COMPLETION_TEXT,
            ConfigurationFields::PAYMENT_METHOD_NAME,
            ConfigurationFields::PAYMENT_METHOD_DETAILS]);
    }

    /**
     * Добавление всех полей
     */
    public function addAll()
    {
        unset($this->fieldsToRender);
        $this->fieldsToRender = $this->allFields;
    }

    /**
     * Добавление всех полей, исключая перечисленные
     */
    public function addAllExcept(array $exclude)
    {
        unset($this->fieldsToRender);
        foreach ($this->allFields as $configField) {
            if (!in_array($configField->getKey(), $exclude)) {
                $this->addField($configField);
            }
        }
    }

    /**
     * Добавление одного поля. Может использоваться в CMS для добавления спец. полей
     */
    public function addField(ConfigField $configField)
    {
        $this->fieldsToRender[$configField->getKey()] = $configField;
    }

    /**
     * Получение поля по ключу
     */
    public function getField($key)
    {
        if (array_key_exists($key, $this->fieldsToRender))
            return $this->fieldsToRender[$key];
        else
            return null;
    }

    /**
     * Производит формирование конечного html с настройками модуля
     * @return string
     */
    public function render()
    {
        $ret = "";
        // при проверке instanceof не забывать про наследование
        foreach ($this->fieldsToRender as $configField) {
            if ($configField instanceof ConfigFieldPassword) {
                $ret .= $this->renderPasswordField($configField);
                continue;
            }
            elseif ($configField instanceof ConfigFieldTextarea) {
                $ret .= $this->renderTextAreaField($configField);
                continue;
            }
            elseif ($configField instanceof ConfigFieldNumber) {
                $ret .= $this->renderNumberField($configField);
                continue;
            }
            elseif ($configField instanceof ConfigFieldCheckbox) {
                $ret .= $this->renderCheckboxField($configField);
                continue;
            }
            elseif ($configField instanceof ConfigFieldStatusList) {
                $ret .= $this->renderStatusListField($configField);
                continue;
            }
            elseif ($configField instanceof ConfigFieldList) {
                $ret .= $this->renderListField($configField);
                continue;
            }
            else
                $ret .= $this->renderTextField($configField);
        }
        return $ret;
    }

    /**
     * Формирование html разметки для текстового поля. Он используется по умолчанию и для всех остальных типов полей
     * (если не переопределены соответствующие методы)
     * @param ConfigField $configField
     * @return mixed
     */
    abstract function renderTextField(ConfigField $configField);

    public function renderTextAreaField(ConfigFieldTextarea $configField)
    {
        return $this->renderTextField($configField);
    }

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

    /**
     * Проверка корректности введенного значения. По кллючу поля $configKey получает соответсвующий ему валидатор
     * и вызывае его для значения $configValue
     * @param $configKey - ключ поля
     * @param $configValue - проверяемое значение
     * @return mixed
     */
    public function validate($configKey, $configValue) {
        $configField = $this->getField($configKey);
        $validator = $configField->getValidator();
        if (!$validator->validate($configValue))
            $this->logger->error("Configuration field[" . $configKey . "] value[" . $configValue . "] is not valid: " . $validator->getErrorText());
        return $validator->getErrorText();
    }

    /**
     * Групповая валидация полей, переданных ввиде массива ключ-значение
     * @param $keyValueArray
     * @return bool
     */
    public function validateAll($keyValueArray) {
        $ret = true;
        $this->validationErrorText = "";
        foreach ($keyValueArray as $key => $value) {
            $validationError = $this->validate($key, $value);
            if ($validationError != null && $validationError != null) {
                $ret = false;
                $this->validationErrorText .= $validationError . "\n";
            }
        }
        return $ret;
    }

    /**
     * @return mixed
     */
    public function getValidationErrorText()
    {
        return $this->validationErrorText;
    }
}