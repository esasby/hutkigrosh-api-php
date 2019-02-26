<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 12:38
 */

namespace esas\hutkigrosh\controllers;


use CMain;
use COption;
use esas\hutkigrosh\lang\TranslatorBitrix;
use esas\hutkigrosh\lang\TranslatorOpencart;
use esas\hutkigrosh\utils\RequestParams;
use esas\hutkigrosh\wrappers\ConfigurationWrapperBitrix;
use esas\hutkigrosh\wrappers\ConfigurationWrapperOpencart;
use esas\hutkigrosh\wrappers\OrderWrapper;
use Registry;

class ControllerWebpayFormSimple extends ControllerWebpayForm
{
    private $returnUrl;

    /**
     * ControllerWebpayForm constructor.
     * @param $returnUrl
     */
    public function __construct($returnUrl)
    {
        parent::__construct();
        $this->returnUrl = $returnUrl;
    }

    /**
     * Основная часть URL для возврата с формы webpay (чаще всего current_url)
     * @return string
     */
    public function getReturnUrl(OrderWrapper $orderWrapper)
    {
        return $this->returnUrl
            . "&" . RequestParams::ORDER_NUMBER . "=" . $orderWrapper->getOrderId()
            . "&" . RequestParams::BILL_ID . "=" . $orderWrapper->getBillId();
    }
}