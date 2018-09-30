<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 12:32
 */

namespace esas\hutkigrosh\controllers;

use esas\hutkigrosh\lang\Translator;
use esas\hutkigrosh\protocol\HutkigroshProtocol;
use esas\hutkigrosh\protocol\WebPayRq;
use esas\hutkigrosh\view\ViewFields;
use esas\hutkigrosh\wrappers\OrderWrapper;
use Exception;
use Throwable;

abstract class ControllerWebpayForm extends Controller
{
    public function __construct($configurationWrapper, Translator $translator)
    {
        parent::__construct($configurationWrapper, $translator);
    }

    /**
     * @param $billId
     * @return \esas\hutkigrosh\protocol\WebPayRs
     * @throws Throwable
     */
    public function process(OrderWrapper $orderWrapper)
    {
        try {
            $loggerMainString = "Order[" . $orderWrapper->getOrderNumber() . "]: ";
            $this->logger->info($loggerMainString . "Controller started");
            $hg = new HutkigroshProtocol($this->configurationWrapper);
            $resp = $hg->apiLogIn();
            if ($resp->hasError()) {
                $hg->apiLogOut();
                throw new Exception($resp->getResponseMessage());
            }
            $webPayRq = new WebPayRq();
            $webPayRq->setBillId($orderWrapper->getBillId());
            $webPayRq->setReturnUrl($this->generateSuccessReturnUrl($orderWrapper));
            $webPayRq->setCancelReturnUrl($this->generateUnsuccessReturnUrl($orderWrapper));
            $webPayRq->setButtonLabel($this->translator->translate(ViewFields::WEBPAY_LABEL));
            $webPayRs = $hg->apiWebPay($webPayRq);
            $hg->apiLogOut();
            $this->logger->info($loggerMainString . "Controller ended");
            return $webPayRs;
        } catch (Throwable $e) {
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
        }
    }

    /**
     * При необходимости, может быть переопределен в дочерних классах
     * @param OrderWrapper $orderWrapper
     * @return string
     */
    public function generateSuccessReturnUrl(OrderWrapper $orderWrapper)
    {
        return $this->getReturnUrl($orderWrapper) . '&webpay_status=payed';
    }

    public function generateUnsuccessReturnUrl(OrderWrapper $orderWrapper)
    {
        return $this->getReturnUrl($orderWrapper) . '&webpay_status=failed';
    }


    /**
     * Основная часть URL для возврата с формы webpay (чаще всего current_url)
     * @return string
     */
    public abstract function getReturnUrl(OrderWrapper $orderWrapper);
}