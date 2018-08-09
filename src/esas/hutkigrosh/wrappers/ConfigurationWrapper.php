<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 13:39
 */

namespace esas\hutkigrosh\wrappers;


use Logger;

abstract class ConfigurationWrapper
{
    const CONFIG_HG_SHOP_NAME = 'hutkigrosh_shop_name';
    const CONFIG_HG_LOGIN = 'hutkigrosh_hg_login';
    const CONFIG_HG_PASSWORD = 'hutkigrosh_hg_password';
    const CONFIG_HG_ERIP_ID = 'hutkigrosh_erip_id';
    const CONFIG_HG_SANDBOX = 'hutkigrosh_sandbox';
    const CONFIG_HG_ALFACLICK_BUTTON = 'hutkigrosh_alfaclick_button';
    const CONFIG_HG_WEBPAY_BUTTON = 'hutkigrosh_webpay_button';
    const CONFIG_HG_EMAIL_NOTIFICATION = 'hutkigrosh_notification_email';
    const CONFIG_HG_SMS_NOTIFICATION = 'hutkigrosh_notification_sms';
    const CONFIG_HG_COMPLETION_TEXT = 'hutkigrosh_completion_text';
    const CONFIG_HG_PAYMENT_METHOD_NAME = 'hutkigrosh_payment_method_name';
    const CONFIG_HG_PAYMENT_METHOD_DETAILS = 'hutkigrosh_payment_method_details';
    const CONFIG_HG_BILL_STATUS_PENDING = 'hutkigrosh_bill_status_pending';
    const CONFIG_HG_BILL_STATUS_PAYED = 'hutkigrosh_bill_status_payed';
    const CONFIG_HG_BILL_STATUS_FAILED = 'hutkigrosh_bill_status_failed';
    const CONFIG_HG_BILL_STATUS_CANCELED = 'hutkigrosh_bill_status_canceled';
    const CONFIG_HG_DUE_INTERVAL = 'hutkigrosh_due_interval';

    protected $logger;

    /**
     * ConfigurationWrapper constructor.
     */
    public function __construct()
    {
        $this->logger = Logger::getLogger(ConfigurationWrapper::class);
    }

    /**
     * Метод для получения значения праметра по ключу
     * @param $config_key
     * @return bool|string
     */
    public function get($config_key)
    {
        switch ($config_key) {
            case self::CONFIG_HG_SHOP_NAME:
                return $this->getShopName();
            case self::CONFIG_HG_LOGIN:
                return $this->getHutkigroshLogin();
            case self::CONFIG_HG_PASSWORD:
                return $this->getHutkigroshPassword();
            case self::CONFIG_HG_ERIP_ID:
                return $this->getEripId();
            case self::CONFIG_HG_SANDBOX:
                return $this->isSandbox();
            case self::CONFIG_HG_ALFACLICK_BUTTON:
                return $this->isAlfaclickButtonEnabled();
            case self::CONFIG_HG_WEBPAY_BUTTON:
                return $this->isWebpayButtonEnabled();
            case self::CONFIG_HG_EMAIL_NOTIFICATION:
                return $this->isEmailNotification();
            case self::CONFIG_HG_SMS_NOTIFICATION:
                return $this->isSmsNotification();
            case self::CONFIG_HG_COMPLETION_TEXT:
                return $this->getCompletionText();
            case self::CONFIG_HG_PAYMENT_METHOD_NAME:
                return $this->getPaymentMethodName();
            case self::CONFIG_HG_PAYMENT_METHOD_DETAILS:
                return $this->getPaymentMethodDetails();
            case self::CONFIG_HG_BILL_STATUS_PENDING:
                return $this->getBillStatusPending();
            case self::CONFIG_HG_BILL_STATUS_PAYED:
                return $this->getBillStatusPayed();
            case self::CONFIG_HG_BILL_STATUS_FAILED:
                return $this->getBillStatusFailed();
            case self::CONFIG_HG_BILL_STATUS_CANCELED:
                return $this->getBillStatusCanceled();
            case self::CONFIG_HG_DUE_INTERVAL:
                return $this->getDueInterval();
            default:
                return null;
        }
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
     * Чаще всего содержит подробную инструкцию по оплате счета в ЕРИП
     * @return string
     */
    public abstract function getCompletionText();

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