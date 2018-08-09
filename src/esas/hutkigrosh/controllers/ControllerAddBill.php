<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 14:13
 */

namespace esas\hutkigrosh\controllers;

use esas\hutkigrosh\protocol\BillNewRq;
use esas\hutkigrosh\protocol\BillNewRs;
use esas\hutkigrosh\protocol\BillProduct;
use esas\hutkigrosh\protocol\HutkigroshProtocol;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;
use esas\hutkigrosh\wrappers\OrderWrapper;
use Exception;
use Logger;

class ControllerAddBill extends Controller
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(ConfigurationWrapper $configurationWrapper)
    {
        parent::__construct($configurationWrapper);
        $this->logger = Logger::getLogger(ControllerAddBill::class);
    }

    /**
     * @param OrderWrapper $orderWrapper
     * @return BillNewRs
     * @throws Exception
     */
    public function process(OrderWrapper $orderWrapper)
    {
        if (empty($orderWrapper)) {
            throw new Exception("Incorrect method call! orderWrapper is null");
        }
        $loggerMainString = "Order[" . $orderWrapper->getOrderNumber() . "]: ";
        $this->logger->info($loggerMainString . "Controller started");
        $hg = new HutkigroshProtocol($this->configurationWrapper);
        $resp = $hg->apiLogIn();
        if ($resp->hasError()) {
            $hg->apiLogOut();
            throw new Exception($resp->getResponseMessage(), $resp->getResponseCode());
        }
        $billNewRq = new BillNewRq();
        $billNewRq->setEripId($this->configurationWrapper->getEripId());
        $billNewRq->setInvId($orderWrapper->getOrderNumber());
        $billNewRq->setFullName($orderWrapper->getFullName());
        $billNewRq->setMobilePhone($orderWrapper->getMobilePhone());
        $billNewRq->setEmail($orderWrapper->getEmail());
        $billNewRq->setFullAddress($orderWrapper->getAddress());
        $billNewRq->setAmount($orderWrapper->getAmount());
        $billNewRq->setCurrency($orderWrapper->getCurrency());
        $billNewRq->setNotifyByEMail($this->configurationWrapper->isEmailNotification());
        $billNewRq->setNotifyByMobilePhone($this->configurationWrapper->isSmsNotification());
        $billNewRq->setDueInterval($this->configurationWrapper->getDueInterval());
        foreach ($orderWrapper->getProducts() as $cartProduct) {
            $product = new BillProduct();
            $product->setName($cartProduct->getName());
            $product->setInvId($cartProduct->getInvId());
            $product->setCount($cartProduct->getCount());
            $product->setUnitPrice($cartProduct->getUnitPrice());
            $billNewRq->addProduct($product);
            unset($product); //??
        }
        $resp = $hg->apiBillNew($billNewRq);
        $hg->apiLogOut();
        if ($resp->hasError()) {
            $this->logger->error($loggerMainString . "Bill was not added. Setting status[" . $this->configurationWrapper->getBillStatusFailed() . "]...");
            $this->onFailed($orderWrapper, $resp);
            throw new Exception($resp->getResponseMessage(), $resp->getResponseCode());
        } else {
            $this->logger->info($loggerMainString . "Bill[" . $resp->getBillId() . "] was successfully added. Updating status[" . $this->configurationWrapper->getBillStatusPending() . "]...");
            $this->onSuccess($orderWrapper, $resp);
        }
        return $resp;
    }

    /**
     * Изменяет статус заказа при успешном высталении счета
     * Вынесено в отдельный метод, для возможности owerrid-а
     * (например, кроме статуса заказа надо еще обновить статус транзакции)
     * @param OrderWrapper $orderWrapper
     * @param BillNewRs $resp
     */
    public function onSuccess(OrderWrapper $orderWrapper, BillNewRs $resp) {
        $orderWrapper->saveBillId($resp->getBillId());
        $orderWrapper->updateStatus($this->configurationWrapper->getBillStatusPending());
    }

    public function onFailed(OrderWrapper $orderWrapper, BillNewRs $resp) {
        $orderWrapper->updateStatus($this->configurationWrapper->getBillStatusFailed());
    }
}