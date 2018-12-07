<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 13:39
 */

namespace esas\hutkigrosh\wrappers;

use esas\hutkigrosh\ConfigurationFields;
use Throwable;

abstract class ConfigurationWrapper extends Wrapper
{
    /**
     * Произольно название интернет-мазагина
     * @return string
     */
    public function getShopName()
    {
        return $this->getConfig(ConfigurationFields::shopName());
    }

    /**
     * Имя пользователя для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshLogin()
    {
        return $this->getConfig(ConfigurationFields::login());
    }

    /**
     * Пароль для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshPassword()
    {
        return $this->getConfig(ConfigurationFields::password());
    }

    /**
     * Название системы ХуткиГрош, отображаемое клиенту на этапе оформления заказа
     * @return string
     */
    public function getPaymentMethodName()
    {
        return $this->getConfig(ConfigurationFields::paymentMethodName());
    }

    /**
     * Описание системы ХуткиГрош, отображаемое клиенту на этапе оформления заказа
     * @return string
     */
    public function getPaymentMethodDetails()
    {
        return $this->getConfig(ConfigurationFields::paymentMethodDetails());
    }

    /**
     * Включен ли режим песчоницы
     * @return boolean
     */
    public function isSandbox()
    {
        return $this->checkOn(ConfigurationFields::sandbox());
    }

    /**
     * Необходимо ли добавлять кнопку "выставить в Alfaclick"
     * @return boolean
     */
    public function isAlfaclickButtonEnabled()
    {
        return $this->checkOn(ConfigurationFields::alfaclickButton());
    }

    /**
     * Необходимо ли добавлять кнопку "оплатить картой"
     * @return boolean
     */
    public function isWebpayButtonEnabled()
    {
        return $this->checkOn(ConfigurationFields::webpayButton());
    }

    /**
     * Уникальный идентификатор услуги в ЕРИП
     * @return string
     */
    public function getEripId()
    {
        return $this->getConfig(ConfigurationFields::eripId());
    }

    /**
     * Номер услуги в дереве ЕРИП
     * @return string
     */
    public function getEripTreeId()
    {
        return $this->getConfig(ConfigurationFields::eripTreeId());
    }

    /**
     * Необходимо ли добавлять секцию с QR-code
     * @return boolean
     */
    public function isQRCodeButtonEnabled()
    {
        return $this->checkOn(ConfigurationFields::qrcodeButton());
    }

    /**
     * Включена ля оповещение клиента по Email
     * @return boolean
     */
    public function isEmailNotification()
    {
        return $this->checkOn(ConfigurationFields::notificationEmail());
    }

    /**
     * Включена ля оповещение клиента по Sms
     * @return boolean
     */
    public function isSmsNotification()
    {
        return $this->checkOn(ConfigurationFields::notificationSms());
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
        $text = $this->getConfig(ConfigurationFields::completionText());
        if ($text == "")
            $text = $this->translator->getConfigFieldDefault(ConfigurationFields::completionText());
        return $text;
    }

    /***
     * В некоторых CMS не получается в настройках хранить html, поэтому использует текст итогового экрана по умолчанию,
     * в который проставлятся значение ERIPPATh
     * @return string
     */
    public function getEripPath()
    {
        return $this->getConfig(ConfigurationFields::eripPath());
    }

    /**
     * Какой статус присвоить заказу после успешно выставления счета в ЕРИП (на шлюз Хуткигрош_
     * @return string
     */
    public function getBillStatusPending()
    {
        return $this->getConfig(ConfigurationFields::billStatusPending());
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusPayed()
    {
        return $this->getConfig(ConfigurationFields::billStatusPayed());
    }

    /**
     * Какой статус присвоить заказу в случаче ошибки выставления счета в ЕРИП
     * @return string
     */
    public function getBillStatusFailed()
    {
        return $this->getConfig(ConfigurationFields::billStatusFailed());
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusCanceled()
    {
        return $this->getConfig(ConfigurationFields::billStatusCanceled());
    }

    /**
     * Какой срок действия счета после его выставления (в днях)
     * @return string
     */
    public function getDueInterval()
    {
        return $this->getConfig(ConfigurationFields::dueInterval());
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
     * @return mixed
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

    /**
     * Метод для получения значения праметра по ключу
     * @param $config_key
     * @return bool|string
     */
    public function get($config_key)
    {
        switch ($config_key) {
            // сперва пробегаем по соответствующим методам, на случай если они были переопределены в дочернем классе
            case ConfigurationFields::shopName():
                return $this->getShopName();
            case ConfigurationFields::login():
                return $this->getHutkigroshLogin();
            case ConfigurationFields::password():
                return $this->getHutkigroshPassword();
            case ConfigurationFields::eripId():
                return $this->getEripId();
            case ConfigurationFields::eripTreeId():
                return $this->getEripTreeId();
            case ConfigurationFields::sandbox():
                return $this->isSandbox();
            case ConfigurationFields::qrcodeButton():
                return $this->isQRCodeButtonEnabled();
            case ConfigurationFields::alfaclickButton():
                return $this->isAlfaclickButtonEnabled();
            case ConfigurationFields::webpayButton():
                return $this->isWebpayButtonEnabled();
            case ConfigurationFields::notificationEmail():
                return $this->isEmailNotification();
            case ConfigurationFields::notificationSms():
                return $this->isSmsNotification();
            case ConfigurationFields::completionText():
                return $this->getCompletionText();
            case ConfigurationFields::paymentMethodName():
                return $this->getPaymentMethodName();
            case ConfigurationFields::paymentMethodDetails():
                return $this->getPaymentMethodDetails();
            case ConfigurationFields::billStatusPending():
                return $this->getBillStatusPending();
            case ConfigurationFields::billStatusPayed():
                return $this->getBillStatusPayed();
            case ConfigurationFields::billStatusFailed():
                return $this->getBillStatusFailed();
            case ConfigurationFields::billStatusCanceled():
                return $this->getBillStatusCanceled();
            case ConfigurationFields::dueInterval():
                return $this->getDueInterval();
            case ConfigurationFields::eripPath():
                return $this->getEripPath();
            default:
                return $this->getConfig($config_key);
        }
    }

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

    public function warnIfEmpty($string, $name)
    {
        if (empty($string)) {
            $this->logger->warn("Configuration field[" . $name . "] is empty.");
        }
        return $string;
    }

    /**
     * При необходимости соблюдения определенных правил в именовании ключей настроек (зависящих от конкретной CMS)
     * Данный метод должен быть переопределен
     * @param $key
     * @return string
     */
    public function createCmsRelatedKey($key) {
        return "hutkigrosh_" . $key;
    }

}