<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 27.09.2018
 * Time: 12:36
 */

namespace esas\hutkigrosh\wrappers;


use esas\hutkigrosh\ConfigurationFields;
use Exception;
use Throwable;

/**
 * Простая реализация ConfigurationWrapper для случая, однотипного доступа ко всем параметрам по ключам
 * В дочерних классах надо реализовать только методы getCmsConfig и convertToBoolean
 * Class ConfigurationSimpleWrapper
 * @package esas\hutkigrosh\wrappers
 */
abstract class ConfigurationSimpleWrapper extends ConfigurationWrapper
{

    /**
     * Произольно название интернет-мазагина
     * @return string
     */
    public function getShopName()
    {
        return $this->getConfig(ConfigurationFields::SHOP_NAME);
    }

    /**
     * Имя пользователя для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshLogin()
    {
        return $this->getConfig(ConfigurationFields::LOGIN);
    }

    /**
     * Пароль для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshPassword()
    {
        return $this->getConfig(ConfigurationFields::PASSWORD);
    }

    /**
     * Название системы ХуткиГрош, отображаемое клиенту на этапе оформления заказа
     * @return string
     */
    public function getPaymentMethodName()
    {
        return $this->getConfig(ConfigurationFields::PAYMENT_METHOD_NAME);
    }

    /**
     * Описание системы ХуткиГрош, отображаемое клиенту на этапе оформления заказа
     * @return string
     */
    public function getPaymentMethodDetails()
    {
        return $this->getConfig(ConfigurationFields::PAYMENT_METHOD_DETAILS);
    }

    /**
     * Включен ли режим песчоницы
     * @return boolean
     */
    public function isSandbox()
    {
        return $this->checkOn(ConfigurationFields::SANDBOX);
    }

    /**
     * Необходимо ли добавлять кнопку "выставить в Alfaclick"
     * @return boolean
     */
    public function isAlfaclickButtonEnabled()
    {
        return $this->checkOn(ConfigurationFields::ALFACLICK_BUTTON);
    }

    /**
     * Необходимо ли добавлять кнопку "оплатить картой"
     * @return boolean
     */
    public function isWebpayButtonEnabled()
    {
        return $this->checkOn(ConfigurationFields::WEBPAY_BUTTON);
    }

    /**
     * Уникальный идентификатор услуги в ЕРИП
     * @return string
     */
    public function getEripId()
    {
        return $this->getConfig(ConfigurationFields::ERIP_ID);
    }

    /**
     * Включена ля оповещение клиента по Email
     * @return boolean
     */
    public function isEmailNotification()
    {
        return $this->checkOn(ConfigurationFields::EMAIL_NOTIFICATION);
    }

    /**
     * Включена ля оповещение клиента по Sms
     * @return boolean
     */
    public function isSmsNotification()
    {
        return $this->checkOn(ConfigurationFields::SMS_NOTIFICATION);
    }

    /**
     * Итоговый текст, отображаемый клиенту после успешного выставления счета
     * Чаще всего содержит подробную инструкцию по оплате счета в ЕРИП.
     * В случае, если итогового текста нет в хранилище настроек, используется дефолтный
     * При необходимости может быть переопрделен
     * @return string
     */
    public function getCompletionText()
    {
        $text = $this->getConfig(ConfigurationFields::COMPLETION_TEXT);
        if ($text == "")
            $text = $this->translator->getConfigFieldDefault(ConfigurationFields::COMPLETION_TEXT);
        return $text;
    }

    /***
     * В некоторых CMS не получается в настройках хранить html, поэтому использует текст итогового экрана по умолчанию,
     * в который проставлятся значение ERIPPATh
     * @return string
     */
    public function getEripPath()
    {
        return $this->getConfig(ConfigurationFields::ERIP_PATH);
    }

    /**
     * Какой статус присвоить заказу после успешно выставления счета в ЕРИП (на шлюз Хуткигрош_
     * @return string
     */
    public function getBillStatusPending()
    {
        return $this->getConfig(ConfigurationFields::BILL_STATUS_PENDING);
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusPayed()
    {
        return $this->getConfig(ConfigurationFields::BILL_STATUS_PAYED);
    }

    /**
     * Какой статус присвоить заказу в случаче ошибки выставления счета в ЕРИП
     * @return string
     */
    public function getBillStatusFailed()
    {
        return $this->getConfig(ConfigurationFields::BILL_STATUS_FAILED);
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusCanceled()
    {
        return $this->getConfig(ConfigurationFields::BILL_STATUS_CANCELED);
    }

    /**
     * Какой срок действия счета после его выставления (в днях)
     * @return string
     */
    public function getDueInterval()
    {
        return $this->getConfig(ConfigurationFields::DUE_INTERVAL);
    }

    public function getConfig($key, $warn = false)
    {
        try {
            $value = $this->getCmsConfig($key);
            if ($warn)
                return $this->warnIfEmpty($value, $key);
            else
                return $value;
        } catch (Throwable $e) {
            $this->logger->error("Can not load config field[" . $key . "]");
        }
    }

    private function checkOn($key)
    {
        $value = false;
        try {
            $value = $this->getCmsConfig($key);
            if (is_bool($value))
                return $value; //уже boolean
            else
                return ("" == $value || "0" == $value) ? false : $this->convertToBoolean($value);
        } catch (Throwable $e) {
            $this->logger->error("Can not load config field[" . $key . "]");
        }
        return $value;
    }


    /**
     * Получение свойства из харнилища настроек конкретной CMS
     * @param string $key
     * @throws Exception
     */
    public abstract function getCmsConfig($key);

    /**
     * Конвертация представляения boolean свойства в boolean тип (во разных CMS в хранилищах настроект boolean могут храниться в разном виде)
     * @param $key
     * @return bool
     * @throws Exception
     */
    public abstract function convertToBoolean($cmsConfigValue);

}