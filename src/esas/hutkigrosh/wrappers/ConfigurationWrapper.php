<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 13:39
 */

namespace esas\hutkigrosh\wrappers;


use esas\hutkigrosh\ConfigurationFields;
use esas\hutkigrosh\lang\Translator;
use Logger;

abstract class ConfigurationWrapper
{
    protected $logger;
    protected $translator;

    /**
     * ConfigurationWrapper constructor.
     */
    public function __construct(Translator $translator)
    {
        $this->logger = Logger::getLogger(ConfigurationWrapper::class);
        $this->translator = $translator;
    }

    /**
     * Метод для получения значения праметра по ключу
     * @param $config_key
     * @return bool|string
     */
    public function get($config_key)
    {
        switch ($config_key) {
            case ConfigurationFields::SHOP_NAME:
                return $this->getShopName();
            case ConfigurationFields::LOGIN:
                return $this->getHutkigroshLogin();
            case ConfigurationFields::PASSWORD:
                return $this->getHutkigroshPassword();
            case ConfigurationFields::ERIP_ID:
                return $this->getEripId();
            case ConfigurationFields::SANDBOX:
                return $this->isSandbox();
            case ConfigurationFields::ALFACLICK_BUTTON:
                return $this->isAlfaclickButtonEnabled();
            case ConfigurationFields::WEBPAY_BUTTON:
                return $this->isWebpayButtonEnabled();
            case ConfigurationFields::EMAIL_NOTIFICATION:
                return $this->isEmailNotification();
            case ConfigurationFields::SMS_NOTIFICATION:
                return $this->isSmsNotification();
            case ConfigurationFields::COMPLETION_TEXT:
                return $this->getCompletionText();
            case ConfigurationFields::PAYMENT_METHOD_NAME:
                return $this->getPaymentMethodName();
            case ConfigurationFields::PAYMENT_METHOD_DETAILS:
                return $this->getPaymentMethodDetails();
            case ConfigurationFields::BILL_STATUS_PENDING:
                return $this->getBillStatusPending();
            case ConfigurationFields::BILL_STATUS_PAYED:
                return $this->getBillStatusPayed();
            case ConfigurationFields::BILL_STATUS_FAILED:
                return $this->getBillStatusFailed();
            case ConfigurationFields::BILL_STATUS_CANCELED:
                return $this->getBillStatusCanceled();
            case ConfigurationFields::DUE_INTERVAL:
                return $this->getDueInterval();
            case ConfigurationFields::ERIP_PATH:
                return $this->getEripPath();
            default:
                return null;
        }
    }

    public function translateFieldName($key) {
        return $this->translator->getConfigFieldName($key);
    }

    public function translateFieldDescription($key) {
        return $this->translator->getConfigFieldDescription($key);
    }

    public function translateFieldDefault($key) {
        return $this->translator->getConfigFieldDefault($key);
    }


    /**
     * Произольно название интернет-мазагина
     * @return string
     */
    public abstract function getShopName();

    /**
     * Имя пользователя для доступа к системе ХуткиГрош
     * @return string
     */
    public abstract function getHutkigroshLogin();

    /**
     * Пароль для доступа к системе ХуткиГрош
     * @return string
     */
    public abstract function getHutkigroshPassword();

    /**
     * Название системы ХуткиГрош, отображаемое клиенту на этапе оформления заказа
     * @return string
     */
    public abstract function getPaymentMethodName();

    /**
     * Описание системы ХуткиГрош, отображаемое клиенту на этапе оформления заказа
     * @return string
     */
    public abstract function getPaymentMethodDetails();

    /**
     * Включен ли режим песчоницы
     * @return boolean
     */
    public abstract function isSandbox();

    /**
     * Необходимо ли добавлять кнопку "выставить в Alfaclick"
     * @return boolean
     */
    public abstract function isAlfaclickButtonEnabled();

    /**
     * Необходимо ли добавлять кнопку "оплатить картой"
     * @return boolean
     */
    public abstract function isWebpayButtonEnabled();

    /**
     * Уникальный идентификатор услуги в ЕРИП
     * @return string
     */
    public abstract function getEripId();

    /**
     * Включена ля оповещение клиента по Email
     * @return boolean
     */
    public abstract function isEmailNotification();

    /**
     * Включена ля оповещение клиента по Sms
     * @return boolean
     */
    public abstract function isSmsNotification();

    /**
     * Итоговый текст, отображаемый клменту после успешного выставления счета
     * Чаще всего содержит подробную инструкцию по оплате счета в ЕРИП.
     * При необходимости может быть переопрделен
     * @return string
     */
    public abstract function getCompletionText();

    /***
     * В некоторых CMS не получается в настройках хранить html, поэтому использует текст итогового экрана по умолчанию,
     * в который проставлятся значение ERIPPATh
     * @return string
     */
    public abstract function getEripPath();

    /**
     * Производит подстановку переменных из заказа в итоговый текст
     * @param OrderWrapper $orderWrapper
     * @return string
     */
    public function cookCompletionText(OrderWrapper $orderWrapper)
    {
        return strtr($this->getCompletionText(), array(
            "@order_id" => $orderWrapper->getOrderId(),
            "@order_number" => $orderWrapper->getOrderNumber(),
            "@order_total" => $orderWrapper->getAmount(),
            "@order_currency" => $orderWrapper->getCurrency(),
            "@order_fullname" => $orderWrapper->getFullName(),
            "@order_phone" => $orderWrapper->getMobilePhone(),
            "@order_address" => $orderWrapper->getAddress(),
            "@erip_path" => $this->getEripPath(),
        ));
    }

    /**
     * Какой статус присвоить заказу после успешно выставления счета в ЕРИП (на шлюз Хуткигрош_
     * @return string
     */
    public abstract function getBillStatusPending();

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public abstract function getBillStatusPayed();

    /**
     * Какой статус присвоить заказу в случаче ошибки выставления счета в ЕРИП
     * @return string
     */
    public abstract function getBillStatusFailed();

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public abstract function getBillStatusCanceled();

    /**
     * Какой срок действия счета после его выставления (в днях)
     * @return string
     */
    public abstract function getDueInterval();

    public function warnIfEmpty($string, $name)
    {
        if (empty($string)) {
            $this->logger->warn("Configuration field[" . $name . "] is empty.");
        }
        return $string;
    }

    public function getNumeric($value, $default = 0) {
        if (empty($value))
            $value = $default;
        return intval($value);
    }
}