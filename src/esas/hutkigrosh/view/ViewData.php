<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 29.09.2018
 * Time: 14:40
 */

namespace esas\hutkigrosh\view;

use esas\hutkigrosh\view\ViewFields;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;
use esas\hutkigrosh\wrappers\OrderWrapper;

/**
 * Класс для группировки полей, доступных на странице успешного выставления счета
 * Class ViewData
 * @package esas\hutkigrosh\view
 */
class ViewData
{
    /**
     * @var ConfigurationWrapper
     */
    private $configurationWrapper;

    /**
     * @var OrderWrapper
     */
    private $orderWrapper;
    /**
     * @var bool
     */
    private $webpayForm;
    private $webpayStatus;

    /**
     * @var bool
     */
    private $alfaclickUrl;

    /**
     * ViewData constructor.
     * @param ConfigurationWrapper $configurationWrapper
     * @param OrderWrapper $orderWrapper
     */
    public function __construct(ConfigurationWrapper $configurationWrapper, OrderWrapper $orderWrapper)
    {
        $this->configurationWrapper = $configurationWrapper;
        $this->orderWrapper = $orderWrapper;
    }


    /**
     * @return mixed
     */
    public function getCompletionText()
    {
        return $this->configurationWrapper->cookCompletionText($this->orderWrapper);
    }

    /**
     * @return bool
     */
    public function isWebpayButtonEnabled()
    {
        return $this->configurationWrapper->isWebpayButtonEnabled();
    }

    /**
     * @return mixed
     */
    public function getWebpayForm()
    {
        return $this->webpayForm;
    }

    /**
     * @param mixed $webpayForm
     */
    public function setWebpayForm($webpayForm)
    {
        $this->webpayForm = $webpayForm;
    }

    /**
     * @return mixed
     */
    public function getWebpayStatus()
    {
        return $this->webpayStatus;
    }

    /**
     * @param mixed $webpayStatus
     */
    public function setWebpayStatus($webpayStatus)
    {
        $this->webpayStatus = $webpayStatus;
    }

    public function getWebpayMsgSuccess() {
        return $this->configurationWrapper->getTranslator()->translate(ViewFields::WEBPAY_MSG_SUCCESS);
    }

    public function getWebpayMsgUnsuccess() {
        return $this->configurationWrapper->getTranslator()->translate(ViewFields::WEBPAY_MSG_UNSUCCESS);
    }

        /**
     * @return bool
     */
    public function isAlfaclickButtonEnabled()
    {
        return $this->configurationWrapper->isAlfaclickButtonEnabled();
    }
    
    /**
     * @return mixed
     */
    public function getAlfaclickBillID()
    {
        return $this->orderWrapper->getBillId();
    }

    /**
     * @return mixed
     */
    public function getAlfaclickPhone()
    {
        return $this->orderWrapper->getMobilePhone();
    }

    /**
     * @return mixed
     */
    public function getAlfaclickUrl()
    {
        return $this->alfaclickUrl;
    }

    /**
     * @param mixed $alfaclickUrl
     */
    public function setAlfaclickUrl($alfaclickUrl)
    {
        $this->alfaclickUrl = $alfaclickUrl;
    }

    /**
     * @return mixed
     */
    public function getAlfaclickLabel()
    {
        return $this->configurationWrapper->getTranslator()->translate(ViewFields::ALFACLICK_LABEL);
    }

    public function getAlfaclickMsgSuccess() {
        return $this->configurationWrapper->getTranslator()->translate(ViewFields::ALFACLICK_MSG_SUCCESS);
    }

    public function getAlfaclickMsgUnsuccess() {
        return $this->configurationWrapper->getTranslator()->translate(ViewFields::ALFACLICK_MSG_UNSUCCESS);
    }
}