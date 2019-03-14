<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 10.10.2018
 * Time: 11:27
 */

namespace esas\hutkigrosh\view\client;


use esas\hutkigrosh\lang\Translator;
use esas\hutkigrosh\Registry;
use esas\hutkigrosh\utils\Logger;
use esas\hutkigrosh\utils\QRUtils;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;
use esas\hutkigrosh\wrappers\OrderWrapper;
use Throwable;

class CompletionPanel
{
    /**
     * @var ConfigurationWrapper
     */
    private $configurationWrapper;

    /**
     * @var Translator
     */
    private $translator;

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
     * @var ViewStyle
     */
    private $viewStyle;

    /**
     * ViewData constructor.
     * @param ConfigurationWrapper $configurationWrapper
     * @param OrderWrapper $orderWrapper
     */
    public function __construct(OrderWrapper $orderWrapper)
    {
        $this->configurationWrapper = Registry::getRegistry()->getConfigurationWrapper();
        $this->translator = Registry::getRegistry()->getTranslator();
        $this->orderWrapper = $orderWrapper;
        $this->viewStyle = new ViewStyle();
    }

    /**
     * @return string
     */
    public function getInstructionsTabLabel()
    {
        return $this->translator->translate(ViewFields::INSTRUCTIONS_TAB_LABEL);
    }

    /**
     * @return string
     */
    public function getInstructionsText()
    {
        return $this->configurationWrapper->cookText($this->translator->translate(ViewFields::INSTRUCTIONS), $this->orderWrapper);
    }


    /**
     * @return mixed
     */
    public function getCompletionText()
    {
        return $this->configurationWrapper->cookText($this->configurationWrapper->getCompletionText(), $this->orderWrapper);
    }

    /**
     * @return bool
     */
    public function isInstructionsSectionEnabled()
    {
        return $this->configurationWrapper->isInstructionsSectionEnabled();
    }

    /**
     * @return bool
     */
    public function isWebpaySectionEnabled()
    {
        return $this->configurationWrapper->isWebpaySectionEnabled();
    }

    /**
     * @return bool
     */
    public function isQRCodeSectionEnabled()
    {
        return $this->configurationWrapper->isQRCodeSectionEnabled();
    }

    /**
     * @return string
     */
    public function getQRCodeTabLabel()
    {
        return $this->translator->translate(ViewFields::QRCODE_TAB_LABEL);
    }

    /**
     * @return string
     */
    public function getQRCodeDetails()
    {
        return strtr($this->translator->translate(ViewFields::QRCODE_DETAILS), array(
            "@qr_code" => QRUtils::getEripBillQR($this->orderWrapper->getOrderNumber())
        ));
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
     * @return string
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

    /**
     * @return string
     */
    public function getWebpayTabLabel()
    {
        return $this->translator->translate(ViewFields::WEBPAY_TAB_LABEL);
    }

    /**
     * @return string
     */
    public function getWebpayButtonLabel()
    {
        return $this->translator->translate(ViewFields::WEBPAY_BUTTON_LABEL);
    }


    /**
     * @return string
     */
    public function getWebpayDetails()
    {
        return $this->translator->translate(ViewFields::WEBPAY_DETAILS);
    }

    /**
     * @return string
     */
    public function getWebpayMsgSuccess()
    {
        return $this->translator->translate(ViewFields::WEBPAY_MSG_SUCCESS);
    }

    /**
     * @return string
     */
    public function getWebpayMsgUnsuccess()
    {
        return $this->translator->translate(ViewFields::WEBPAY_MSG_UNSUCCESS);
    }

    /**
     * @return string
     */
    public function getWebpayMsgUnavailable()
    {
        return $this->translator->translate(ViewFields::WEBPAY_MSG_UNAVAILABLE);
    }

    /**
     * @return bool
     */
    public function isAlfaclickSectionEnabled()
    {
        return $this->configurationWrapper->isAlfaclickSectionEnabled();
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
     * @return string
     */
    public function getAlfaclickTabLabel()
    {
        return $this->translator->translate(ViewFields::ALFACLICK_TAB_LABEL);
    }

    /**
     * @return string
     */
    public function getAlfaclickButtonLabel()
    {
        return $this->translator->translate(ViewFields::ALFACLICK_BUTTON_LABEL);
    }

    /**
     * @return string
     */
    public function getAlfaclickDetails()
    {
        return $this->translator->translate(ViewFields::ALFACLICK_DETAILS);
    }

    /**
     * @return string
     */
    public function getAlfaclickMsgSuccess()
    {
        return $this->translator->translate(ViewFields::ALFACLICK_MSG_SUCCESS);
    }

    /**
     * @return string
     */
    public function getAlfaclickMsgUnsuccess()
    {
        return $this->translator->translate(ViewFields::ALFACLICK_MSG_UNSUCCESS);
    }

    /**
     * @return ViewStyle
     */
    public function getViewStyle()
    {
        return $this->viewStyle;
    }

    public function render()
    {
        $viewData = $this;
        $viewStyle = $this->viewStyle;
        try {
            include(dirname(__FILE__) . "/completionAccordion.php");
        } catch (Throwable $e) {
            Logger::getLogger("CompletionPanel")->error("Exception:", $e);
        }
    }
}