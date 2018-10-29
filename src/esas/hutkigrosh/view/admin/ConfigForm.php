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
use esas\hutkigrosh\view\admin\validators\ValidationResult;
use esas\hutkigrosh\view\admin\validators\ValidatorInteger;
use esas\hutkigrosh\view\admin\validators\ValidatorNotEmpty;

/**
 * Class ConfigForm обеспечивает генерация формы с настройками плагина (может быть как генерация конечного html,
 * так и каких-то промежуточных структур, в зависимости от CMS)
 * В плагинах для конкретных CMS должен быть создан наследник и переопределены методы generate****Field
 * (минимум должен быть переопределен generateTextField).
 * Пример использования для opencart:
 * $configForm = new ConfigFormOpencart();
 * $configForm->addAll();
 * $configForm->addField(new ConfigFieldNumber <> ); // добавление какого-то особоного поля для CMS
 * $configForm->generate(); // формирует форму
 * @package esas\hutkigrosh\view\admin
 */
abstract class ConfigForm
{
    /**
     * Массив настроек, которые должны быть отображены для конкретного модуля
     * @var ConfigField[]
     */
    protected $fieldsToRender;

    /**
     * Массив для хранения всех возможнах настроек модуля
     * @var ConfigField[]
     */
    protected $allFields;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Общий итоговый текст, содержащий все ошибки валидации
     * @var string
     */
    protected $validationErrorText;

    /**
     * ConfigurationRender constructor.
     */
    public function __construct()
    {
        $this->logger = Logger::getLogger(get_class($this));
        $this->registerField(
            (new ConfigFieldText(ConfigurationFields::SHOP_NAME))
                ->setValidator(new ValidatorNotEmpty())
                ->setRequired(false));
        $this->registerField(
            (new ConfigFieldText(ConfigurationFields::LOGIN))
                ->setValidator(new ValidatorNotEmpty())
                ->setRequired(false));
        $this->registerField(
            (new ConfigFieldPassword(ConfigurationFields::PASSWORD))
                ->setValidator(new ValidatorNotEmpty())
                ->setRequired(false));
        $this->registerField(
            (new ConfigFieldNumber(ConfigurationFields::ERIP_ID))
                ->setMin(10000000)
                ->setMax(99999999)
                ->setValidator(new ValidatorInteger(10000000, 99999999))
                ->setRequired(true));
        $this->registerField(
            (new ConfigFieldCheckbox(ConfigurationFields::SANDBOX))
                ->setDefault(true));
        $this->registerField(
            (new ConfigFieldCheckbox(ConfigurationFields::EMAIL_NOTIFICATION))
                ->setDefault(true));
        $this->registerField(
            (new ConfigFieldCheckbox(ConfigurationFields::SMS_NOTIFICATION))
                ->setDefault(false));
        $this->registerField(
            (new ConfigFieldText(ConfigurationFields::ERIP_PATH))
                ->setRequired(true)
                ->setValidator(new ValidatorNotEmpty()));
        $this->registerField(
            (new ConfigFieldNumber(ConfigurationFields::DUE_INTERVAL))
                ->setMin(1)
                ->setMax(10)
                ->setValidator(new ValidatorInteger(1, 10))
                ->setDefault(2)
                ->setRequired(true));
        $this->registerField(new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_PENDING));
        $this->registerField(new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_PAYED));
        $this->registerField(new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_FAILED));
        $this->registerField(new ConfigFieldStatusList(ConfigurationFields::BILL_STATUS_CANCELED));
        $this->registerField(
            (new ConfigFieldCheckbox(ConfigurationFields::ALFACLICK_BUTTON))
                ->setDefault(false));
        $this->registerField(
            (new ConfigFieldCheckbox(ConfigurationFields::WEBPAY_BUTTON))
                ->setDefault(false));
        $this->registerField(
            (new ConfigFieldTextarea(ConfigurationFields::COMPLETION_TEXT))
                ->setRequired(true));
        $this->registerField(
            (new ConfigFieldText(ConfigurationFields::PAYMENT_METHOD_NAME))
                ->setRequired(true)
                ->setValidator(new ValidatorNotEmpty()));
        $this->registerField(
            (new ConfigFieldTextarea(ConfigurationFields::PAYMENT_METHOD_DETAILS))
                ->setRequired(true)
                ->setValidator(new ValidatorNotEmpty()));

    }

    /**
     * Внутренний метод для заполнения массива всез настроек
     * @param ConfigField $configField
     */
    private function registerField(ConfigField $configField)
    {
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
     * Производит формирование формы с настройками модуля
     * @return string
     */
    public abstract function generate();

    /**
     * Формирование html разметки для текстового поля. Он используется по умолчанию и для всех остальных типов полей
     * (если не переопределены соответствующие методы)
     * @param ConfigField $configField
     * @return mixed
     */
    abstract function generateTextField(ConfigField $configField);

    public function generateTextAreaField(ConfigFieldTextarea $configField)
    {
        return $this->generateTextField($configField);
    }

    public function generateNumberField(ConfigFieldNumber $configField)
    {
        return $this->generateTextField($configField);
    }

    public function generatePasswordField(ConfigFieldPassword $configField)
    {
        return $this->generateTextField($configField);
    }

    public function generateCheckboxField(ConfigFieldCheckbox $configField)
    {
        return $this->generateTextField($configField);
    }

    public function generateStatusListField(ConfigFieldStatusList $configField)
    {
        return $this->generateTextField($configField);
    }

    public function renderListField(ConfigFieldList $configField)
    {
        return $this->generateTextField($configField);
    }

    /**
     * Проверка корректности введенного значения. По кллючу поля $configKey получает соответсвующий ему валидатор
     * и вызывае его для значения $configValue
     * @param $configKey - ключ поля
     * @param $configValue - проверяемое значение
     * @return ValidationResult
     */
    public function validate($configKey, $configValue)
    {
        $configField = $this->getField($configKey);
        $validationResult = $configField->validate($configValue);
        if (!$validationResult->isValid()) {
            $this->logger->error("Configuration field[" . $configKey . "] value[" . $configValue . "] is not valid: " . $validationResult->getErrorTextSimple());
            $this->validationErrorText .= $validationResult->getErrorTextFull() . "\n";
        }
        return $validationResult;
    }

    /**
     * Групповая валидация полей, переданных ввиде массива ключ-значение
     * @param $keyValueArray
     * @return bool
     */
    public function validateAll($keyValueArray)
    {
        $ret = true;
        $this->validationErrorText = "";
        foreach ($keyValueArray as $key => $value) {
            if (!$this->validate($key, $value)->isValid()) {
                $ret = false;
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