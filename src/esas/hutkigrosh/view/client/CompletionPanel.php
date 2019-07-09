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
use esas\hutkigrosh\utils\htmlbuilder\Attributes as attribute;
use esas\hutkigrosh\utils\htmlbuilder\Elements as element;
use esas\hutkigrosh\utils\Logger;
use esas\hutkigrosh\utils\QRUtils;
use esas\hutkigrosh\utils\ResourceUtils;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;
use esas\hutkigrosh\wrappers\OrderWrapper;

/**
 * Class CompletionPanel используется для формирования итоговой страницы. Основной класс
 * для темазависимого представления (HGCMS-23).
 * Разбит на множество мелких методов для возможности легкого переопрделения. Что позволяет формировать итоговоую
 * страницу в тегах и CSS-классах принятых в конкретных CMS
 * @package esas\hutkigrosh\view\client
 */
class CompletionPanel
{
    /**
     * @var Logger
     */
    protected $logger;
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
    public function __construct(OrderWrapper $orderWrapper)
    {
        $this->logger = Logger::getLogger(get_class($this));
        $this->configurationWrapper = Registry::getRegistry()->getConfigurationWrapper();
        $this->translator = Registry::getRegistry()->getTranslator();
        $this->orderWrapper = $orderWrapper;
    }

    public function render()
    {
        $completionPanel = element::content(
            element::div(
                attribute::id("completion-text"),
                attribute::clazz($this->getCssClass4CompletionTextDiv()),
                element::content($this->getCompletionText())
            ),
            element::div(
                attribute::id("hutkigrosh-completion-tabs"),
                attribute::clazz($this->getCssClass4TabsGroup()),
                $this->elementInstructionsTab(),
                $this->elementQRCodeTab(),
                $this->elementWebpayTab(),
                $this->elementAlfaclickTab()),
            element::styleFile($this->getCoreCSSFilePath()), // CSS для аккордеона, общий для всех
            element::styleFile($this->getModuleCSSFilePath()), // CSS, специфичный для модуля
            element::styleFile($this->getAdditionalCSSFilePath()) // CSS заданный администратором в настройках модуля
        );
        echo $completionPanel;
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
     * @return string
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


    public function elementTab($key, $header, $body)
    {
        return
            element::div(
                attribute::id("tab-" . $key),
                attribute::clazz("tab " . $this->getCssClass4Tab()),
                element::input(
                    attribute::id("input-" . $key),
                    attribute::type("radio"),
                    attribute::name("tabs2"),
                    attribute::checked($this->isTabChecked($key))
                ),
                element::div(
                    attribute::clazz("tab-header " . $this->getCssClass4TabHeader()),
                    element::label(
                        attribute::forr("input-" . $key),
                        attribute::clazz($this->getCssClass4TabHeaderLabel()),
                        element::content($header)
                    )
                ),
                element::div(
                    attribute::clazz("tab-body " . $this->getCssClass4TabBody()),
                    element::div(
                        attribute::id($key . "-content"),
                        attribute::clazz("tab-body-content " . $this->getCssClass4TabBodyContent()),
                        element::content($body)
                    )
                )
            )->__toString();
    }

    public function isTabChecked($tabKey) {
        $webpayStatusPresent = '' != $this->getWebpayStatus();
        switch ($tabKey) {
            case self::TAB_KEY_INSTRUCTIONS:
                return !$webpayStatusPresent;
            case self::TAB_KEY_WEBPAY:
                return $webpayStatusPresent;
            default:
                return false;
        }
    }

    const TAB_KEY_WEBPAY = "webpay";
    const TAB_KEY_INSTRUCTIONS = "instructions";
    const TAB_KEY_QRCODE = "qrcode";
    const TAB_KEY_ALFACLICK = "alfaclick";

    public function elementWebpayTab()
    {
        if ($this->isWebpaySectionEnabled()) {
            return $this->elementTab(
                self::TAB_KEY_WEBPAY,
                $this->getWebpayTabLabel(),
                $this->elementWebpayTabContent($this->getWebpayStatus(), $this->getWebpayForm()));
        }
        return "";
    }

    public function elementInstructionsTab()
    {
        if ($this->isInstructionsSectionEnabled()) {
            return $this->elementTab(
                self::TAB_KEY_INSTRUCTIONS,
                $this->getInstructionsTabLabel(),
                $this->getInstructionsText());
        }
        return "";
    }

    public function elementQRCodeTab()
    {
        if ($this->isQRCodeSectionEnabled()) {
            return $this->elementTab(
                self::TAB_KEY_QRCODE,
                $this->getQRCodeTabLabel(),
                $this->getQRCodeDetails());
        }
        return "";
    }

    public function elementAlfaclickTab()
    {
        if ($this->isAlfaclickSectionEnabled()) {
            return $this->elementTab(
                self::TAB_KEY_ALFACLICK,
                $this->getAlfaclickTabLabel(),
                $this->elementAlfaclickTabContent());
        }
        return "";
    }

    public function getCoreCSSFilePath() {
        return dirname(__FILE__) . "/accordion.css";
    }

    public function getModuleCSSFilePath() {
        return "";
    }

    public function getAdditionalCSSFilePath() {
        if ("default" == $this->configurationWrapper->getCompletionCssFile())
            return dirname(__FILE__) . "/completion-default.css";
        else
            return $_SERVER['DOCUMENT_ROOT'] . $this->configurationWrapper->getCompletionCssFile();
    }

    const STATUS_PAYED = 'payed';
    const STATUS_FAILED = 'failed';

    public function elementWebpayTabContent($status, $webpayForm)
    {
        $ret =
            element::div(
                attribute::id("webpay_details"),
                element::content($this->translator->translate(ViewFields::WEBPAY_DETAILS)),
                element::br());

        $ret .= $this->elementWebpayTabContentResultMsg($status);

        if ("" != $webpayForm) {
            $ret .=
                element::div(
                    attribute::id("webpay"),
                    attribute::align("right"),
                    element::img(
                        attribute::id("webpay-ps-image"),
                        attribute::src(ResourceUtils::getImageUrl('ps_icons.png')),
                        attribute::alt("")
                    ),
                    element::br(),
                    element::content($webpayForm),
                    element::includeFile(dirname(__FILE__) . "/webpayJs.php", ["completionPanel" => $this]));
        } else {
            $ret .=
                element::div(
                    attribute::id("webpay_message_unavailable"),
                    element::content($this->translator->translate(ViewFields::WEBPAY_MSG_UNAVAILABLE)));
        }
        return $ret;
    }

    public function elementWebpayTabContentResultMsg($status)
    {
        if (self::STATUS_PAYED == $status) {
            return
                element::div(
                    attribute::clazz($this->getCssClass4MsgSuccess()),
                    attribute::id("webpay_message"),
                    element::content($this->translator->translate(ViewFields::WEBPAY_MSG_SUCCESS)));
        } elseif (self::STATUS_FAILED == $status) {
            return
                element::div(
                    attribute::clazz($this->getCssClass4MsgUnsuccess()),
                    attribute::id("webpay_message"),
                    element::content($this->translator->translate(ViewFields::WEBPAY_MSG_UNSUCCESS)));
        } else
            return "";
    }

    const ALFACLICK_URL = "alfaclickurl";

    public function elementAlfaclickTabContent()
    {
        $content =
            element::content(
                element::div(
                    attribute::id("alfaclick_details"),
                    element::content($this->getAlfaclickDetails()),
                    element::br()),
                $this->elementAlfaclickTabContentForm(),
                element::includeFile(dirname(__FILE__) . "/alfaclickJs.php", ["completionPanel" => $this]));

        return $content;
    }

    public function elementAlfaclickTabContentForm()
    {
        return
            element::div(
                attribute::id("alfaclick_form"),
                attribute::clazz($this->getCssClass4AlfaclickForm()),
                attribute::align("right"),
                element::input(
                    attribute::id("billID"),
                    attribute::type('hidden'),
                    attribute::value($this->getAlfaclickBillID())),
                element::input(
                    attribute::id("phone"),
                    attribute::type('tel'),
                    attribute::value($this->getAlfaclickPhone()),
                    attribute::clazz($this->getCssClass4FormInput()),
                    attribute::maxlength('20')),
                element::a(
                    attribute::clazz($this->getCssClass4AlfaclickButton()),
                    attribute::id("alfaclick_button"),
                    element::content($this->getAlfaclickButtonLabel()))
            );
    }


    /**
     * @return string
     */
    public function getCssClass4Tab()
    {
        return "";
    }

    /**
     * @return string
     */
    public function getCssClass4TabHeader()
    {
        return "";
    }

    /**
     * @return string
     */
    public function getCssClass4TabHeaderLabel()
    {
        return "";
    }

    /**
     * @return string
     */
    public function getCssClass4TabBody()
    {
        return "";
    }

    /**
     * @return string
     */
    public function getCssClass4TabBodyContent()
    {
        return "";
    }

    /**
     * @return string
     */
    public function getCssClass4MsgSuccess()
    {
        return "";
    }

    /**
     * @return string
     */
    public function getCssClass4MsgUnsuccess()
    {
        return "";
    }

    /**
     * @return string
     */
    public function getCssClass4CompletionTextDiv()
    {
        return "";
    }

    /**
     * @return string
     */
    public function getCssClass4TabsGroup()
    {
        return "";
    }


    /**
     * @return string
     */
    public function getCssClass4AlfaclickButton()
    {
        return $this->getCssClass4Button();
    }

    /**
     * @return string
     */
    public function getCssClass4WebpayButton()
    {
        return $this->getCssClass4Button();
    }

    /**
     * @return string
     */
    public function getCssClass4Button()
    {
        return "";
    }

    public function getCssClass4AlfaclickForm()
    {
        return "";
    }

    public function getCssClass4FormInput()
    {
        return "";
    }
}