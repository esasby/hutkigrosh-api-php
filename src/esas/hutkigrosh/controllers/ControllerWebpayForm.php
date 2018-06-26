<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 12:32
 */

namespace esas\hutkigrosh\controllers;

use esas\hutkigrosh\protocol\HutkigroshProtocol;
use esas\hutkigrosh\protocol\WebPayRq;
use Exception;
use Logger;

abstract class ControllerWebpayForm extends Controller
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct($configurationWrapper)
    {
        parent::__construct($configurationWrapper);
        $this->logger = Logger::getLogger(ControllerWebpayForm::class);
    }

    /**
     * @param $billId
     * @return \esas\hutkigrosh\protocol\WebPayRs
     * @throws Exception
     */
    public function process($billId)
    {
        $hg = new HutkigroshProtocol($this->configurationWrapper);
        $resp = $hg->apiLogIn();
        if ($resp->hasError()) {
            $hg->apiLogOut();
            throw new Exception($resp->getResponseMessage());
        }
        $webPayRq = new WebPayRq();
        $webPayRq->setBillId($billId);
        $webPayRq->setReturnUrl($this->getReturnUrl() . '&webpay_status=payed');
        $webPayRq->setCancelReturnUrl($this->getReturnUrl() . '&webpay_status=failed');
        $webPayRs = $hg->apiWebPay($webPayRq);
        $hg->apiLogOut();
        return $webPayRs;
    }

    /**
     * Основная часть URL для возврата с формы webpay (чаще всего current_url)
     * @return string
     */
    public abstract function getReturnUrl();
}