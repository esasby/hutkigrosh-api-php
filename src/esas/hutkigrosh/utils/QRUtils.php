<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 03.12.2018
 * Time: 12:55
 */

namespace esas\hutkigrosh\utils;


use Com\Tecnick\Barcode\Barcode;
use esas\hutkigrosh\Registry;

class QRUtils
{

    public static function getEripBillQR($orderNumber)
    {
        $configurationWrapper = Registry::getRegistry()->getConfigurationWrapper();
        $orderWrapper = Registry::getRegistry()->getOrderWrapper($orderNumber);
        $qrCodeString =
            self::tlv(0, "01") .
            self::tlv(1, "11") .
            self::tlv(32,
                self::tlv(0, "by.raschet") .
                self::tlv(1, $configurationWrapper->getEripTreeId()) .
                self::tlv(10, $orderWrapper->getOrderNumber()) .
                self::tlv(12, "12")) .
            self::tlv(53, "933") .
            self::tlv(54, $orderWrapper->getAmount()) .
            self::tlv(58, "BY") .
            ($configurationWrapper->getShopName() != "" ? self::tlv(59, $configurationWrapper->getShopName()) : "") .
            self::tlv(60, "Belarus") .
            self::tlv(62, self::tlv(1, $orderWrapper->getOrderNumber()));
        $qrCodeString =
            "https://pay.raschet.by#" .
            $qrCodeString .
            strtoupper(self::tlv(63, substr(str_replace("-", "", hash('sha256', $qrCodeString)), -4)));
        $barcode = new Barcode();
        $bobj = $barcode->getBarcodeObj(
            'QRCODE,H',                     // barcode type and additional comma-separated parameters
            $qrCodeString,          // data string to encode
            -4,                             // bar width (use absolute or negative value as multiplication factor)
            -4,                             // bar height (use absolute or negative value as multiplication factor)
            'black',                        // foreground color
            array(-2, -2, -2, -2)           // padding (use absolute or negative values as multiplication factors)
        );
        return $bobj->getSvgCode();
    }

    private static function tlv($tag, $value)
    {
        return $value == "" ? "" : sprintf("%02d%02d%s", $tag, strlen($value), $value);
    }
}