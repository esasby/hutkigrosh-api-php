<?php

namespace esas\hutkigrosh\controllers;

use esas\hutkigrosh\protocol\BillInfoRq;
use esas\hutkigrosh\protocol\HutkigroshProtocol;
use esas\hutkigrosh\protocol\LoginRq;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;
use esas\hutkigrosh\wrappers\OrderWrapper;
use Exception;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 11:37
 */
abstract class ControllerNotify extends Controller
{
    public function __construct(ConfigurationWrapper $configurationWrapper, Logger $logger)
    {
        parent::__construct($configurationWrapper, $logger);
    }


    public function process($billId)
    {
        if (empty($billId))
            throw new Exception('Wrong billid[' . $billId . "]");
        $hg = new HutkigroshProtocol($this->configurationWrapper);
        $resp = $hg->apiLogIn(new LoginRq($this->configurationWrapper->getHutkigroshLogin(), $this->configurationWrapper->getHutkigroshPassword()));
        if ($resp->hasError()) {
            $hg->apiLogOut();
            throw new Exception($resp->getResponseMessage(), $resp->getResponseCode());
        }
        $billInfoRs = $hg->apiBillInfo(new BillInfoRq($billId));
        $hg->apiLogOut();
        if ($billInfoRs->hasError())
            throw new Exception($resp->getResponseMessage(), $resp->getResponseCode());
        $this->getLogger()->info()
        $localOrderWrapper = $this->getOrderWrapper($billInfoRs->getInvId());
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
            $localOrderWrapper->updateStatus($status);
        }
    }

    /**
     * По локальному идентификатору заказа возвращает wrapper
     * @param $orderId
     * @return OrderWrapper
     */
    public abstract function getOrderWrapper($orderId);

}