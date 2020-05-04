<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 10.08.2018
 * Time: 12:21
 */

namespace esas\hutkigrosh;


class ConfigurationFields
{
    private static $cmsKeys;

    /**
     * В некоторых CMS используются определенные соглашения по именования настроек модулей (чаще всего префиксы).
     * Данный метод позволяет использовать в core cms-зависимые ключи (например на client view, при формировании html и т.д.)
     * @param $localkey
     * @return mixed
     */
    private static function getCmsRelatedKey($localkey)
    {
        if (self::$cmsKeys == null || !in_array($localkey, self::$cmsKeys)) {
            self::$cmsKeys[$localkey] = Registry::getRegistry()->getConfigurationWrapper()->createCmsRelatedKey($localkey);
        }
        return self::$cmsKeys[$localkey];
    }

    public static function shopName()
    {
        return self::getCmsRelatedKey("shop_name");
    }

    public static function login()
    {
        return self::getCmsRelatedKey("hg_login");
    }

    public static function password()
    {
        return self::getCmsRelatedKey("hg_password");
    }

    public static function eripId()
    {
        return self::getCmsRelatedKey("erip_id");
    }

    public static function eripTreeId()
    {
        return self::getCmsRelatedKey("erip_tree_id");
    }

    public static function sandbox()
    {
        return self::getCmsRelatedKey("sandbox");
    }

    public static function instructionsSection()
    {
        return self::getCmsRelatedKey("instructions_section");
    }

    public static function qrcodeSection()
    {
        return self::getCmsRelatedKey("qrcode_section");
    }

    public static function webpaySection()
    {
        return self::getCmsRelatedKey("webpay_section");
    }

    public static function alfaclickSection()
    {
        return self::getCmsRelatedKey("alfaclick_section");
    }

    public static function notificationEmail()
    {
        return self::getCmsRelatedKey("notification_email");
    }

    public static function notificationSms()
    {
        return self::getCmsRelatedKey("notification_sms");
    }

    public static function completionText()
    {
        return self::getCmsRelatedKey("completion_text");
    }

    public static function completionCssFile()
    {
        return self::getCmsRelatedKey("completion_css_file");
    }

    public static function eripPath()
    {
        return self::getCmsRelatedKey("erip_path");
    }

    public static function paymentMethodName()
    {
        return self::getCmsRelatedKey("payment_method_name");
    }

    public static function paymentMethodDetails()
    {
        return self::getCmsRelatedKey("payment_method_details");
    }

    public static function billStatusPending()
    {
        return self::getCmsRelatedKey("bill_status_pending");
    }

    public static function billStatusPayed()
    {
        return self::getCmsRelatedKey("bill_status_payed");
    }

    public static function billStatusFailed()
    {
        return self::getCmsRelatedKey("bill_status_failed");
    }

    public static function billStatusCanceled()
    {
        return self::getCmsRelatedKey("bill_status_canceled");
    }

    public static function dueInterval()
    {
        return self::getCmsRelatedKey("due_interval");
    }

    public static function cookiePath()
    {
        return self::getCmsRelatedKey("cookie_path");
    }
}