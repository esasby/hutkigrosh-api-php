<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 14:13
 */

namespace esas\hutkigrosh\controllers;

use esas\hutkigrosh\Registry;
use esas\hutkigrosh\utils\RequestParams;
use esas\hutkigrosh\view\client\CompletionPanel;
use esas\hutkigrosh\wrappers\OrderWrapper;
use Exception;
use Throwable;

class ControllerCompletionPage extends Controller
{
    private $alfaclickUrl;
    private $webpayReturnUrl;

    /**
     * ControllerWebpayForm constructor.
     * @param $returnUrl
     */
    public function __construct($alfaclickUrl, $webpayReturnUrl)
    {
        parent::__construct();
        $this->alfaclickUrl = $alfaclickUrl;
        $this->webpayReturnUrl = $webpayReturnUrl;
    }

    /**
     * @param OrderWrapper $orderWrapper
     * @return CompletionPanel
     * @throws Throwable
     */
    public function process($orderNumber)
    {
        try {
            $orderWrapper = Registry::getRegistry()->getOrderWrapper($orderNumber);
            $loggerMainString = "Order[" . $orderWrapper->getOrderNumber() . "]: ";
            $this->logger->info($loggerMainString . "Controller started");
            // Проверяем, привязан ли к заказу billid. Если нет, то генерируем исключени.
            // Здесь не стоит вызывать ControllerAddBill с точки зрения безопасности
            if (empty($orderWrapper->getBillId())) {
                throw new Exception("Bill was not added. Please try to recreate order");
            }
            $configurationWrapper = Registry::getRegistry()->getConfigurationWrapper();
            $completionPanel = Registry::getRegistry()->getCompletionPanel($orderWrapper);
            if ($configurationWrapper->isAlfaclickSectionEnabled()) {
                $completionPanel->setAlfaclickUrl($this->alfaclickUrl);
            }
            if ($configurationWrapper->isWebpaySectionEnabled()) {
                $controller = new ControllerWebpayFormSimple($this->webpayReturnUrl);
                $webpayResp = $controller->process($orderWrapper);
                $completionPanel->setWebpayForm($webpayResp->getHtmlForm());
                if (array_key_exists(RequestParams::WEBPAY_STATUS, $_REQUEST))
                    $completionPanel->setWebpayStatus($_REQUEST[RequestParams::WEBPAY_STATUS]);
            }
            return $completionPanel;
        } catch (Throwable $e) {
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
            throw $e;
        } catch (Exception $e) { // для совместимости с php 5
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
            throw $e;
        }
    }
}