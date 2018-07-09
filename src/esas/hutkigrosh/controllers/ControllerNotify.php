<?php

namespace esas\hutkigrosh\controllers;

use esas\hutkigrosh\protocol\BillInfoRq;
use esas\hutkigrosh\protocol\HutkigroshProtocol;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;
use esas\hutkigrosh\wrappers\OrderWrapper;
use Exception;
use Logger;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 11:37
 */
abstract class ControllerNotify extends Controller
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(ConfigurationWrapper $configurationWrapper)
    {
        parent::__construct($configurationWrapper);
        $this->logger = Logger::getLogger(ControllerNotify::class);
    }

    /**
     * @param $billId
     * @throws Exception
     */
    public function process($billId)
    {
        $loggerMainString = "Bill[" . $billId . "]: ";
        $this->logger->info($loggerMainString . "Controller started");
        if (empty($billId))
            throw new Exception('Wrong billid[' . $billId . "]");
        $hg = new HutkigroshProtocol($this->configurationWrapper);
        $resp = $hg->apiLogIn();
        if ($resp->hasError()) {
            $hg->apiLogOut();
            throw new Exception($resp->getResponseMessage(), $resp->getResponseCode());
        }
        $billInfoRs = $hg->apiBillInfo(new BillInfoRq($billId));
        $hg->apiLogOut();
        if ($billInfoRs->hasError())
            throw new Exception($resp->getResponseMessage(), $resp->getResponseCode());
        $this->logger->info($loggerMainString . 'Loading local order object for id[' . $billInfoRs->getInvId() . "]");
        $localOrderWrapper = $this->getOrderWrapperByOrderNumber($billInfoRs->getInvId());
        if (empty($localOrderWrapper))
            throw new Exception('Can not load order info for id[' . $billInfoRs->getInvId() . "]");
        if ($billInfoRs->getFullName() != $localOrderWrapper->getFullName() || $billInfoRs->getAmount() != $localOrderWrapper->getAmount()) {
            throw new Exception("Unmapped purchaseid: localFullname[" . $localOrderWrapper->getFullName()
                . "], remoteFullname[" . $billInfoRs->getFullName()
                . "], localAmount[" . $localOrderWrapper->getAmount()
                . "], remoteAmount[" . $billInfoRs->getAmount() . "]");
        }
        if ($billInfoRs->isStatusPayed()) {
            $status = $this->configurationWrapper->getBillStatusPayed();
        } elseif ($billInfoRs->isStatusCanceled()) {
            $status = $this->configurationWrapper->getBillStatusCanceled();
        } elseif ($billInfoRs->isStatusPending()) {
            $status = $this->configurationWrapper->getBillStatusPending();
        }
        if (isset($status) && $localOrderWrapper->getStatus() != $status) {
            $this->logger->info($loggerMainString . "Setting status[" . $status . "] for order[" . $billInfoRs->getInvId() . "]...");
            $localOrderWrapper->updateStatus($status);
        }
        $this->logger->info($loggerMainString . "Controller ended");
    }

    /**
     * По локальному номеру счета (номеру заказа) возвращает wrapper
     * @param $orderId
     * @return OrderWrapper
     */
    public abstract function getOrderWrapperByOrderNumber($orderNumber);

}