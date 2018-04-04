<?php

namespace esas\hutkigrosh\controllers;

use esas\hutkigrosh\protocol\AlfaclickRq;
use esas\hutkigrosh\protocol\HutkigroshProtocol;
use esas\hutkigrosh\protocol\LoginRq;
use Exception;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 11:30
 */
class ControllerAlfaclick
{
    private $configurationWrapper;

    /**
     * ControlllerAlfaclick constructor.
     * @param $configurationWrapper
     */
    public function __construct($configurationWrapper)
    {
        $this->configurationWrapper = $configurationWrapper;
    }

    public function process($billId, $phone)
    {
        try {
            if (empty($billId) || empty($phone))
                throw new Exception('Wrong billid[' . $billId . "] or phone[" . $phone . "]");
            $hg = new HutkigroshProtocol($this->configurationWrapper->isSandbox());
            $resp = $hg->apiLogIn(new LoginRq($this->configurationWrapper->getHutkigroshLogin(), $this->configurationWrapper->getHutkigroshPassword()));
            if ($resp->hasError()) {
                $hg->apiLogOut();
                throw new Exception($resp->getResponseMessage());
            }

            $alfaclickRq = new AlfaclickRq();
            $alfaclickRq->setBillId($billId);
            $alfaclickRq->setPhone($phone);

            $resp = $hg->apiAlfaClick($alfaclickRq);
            $hg->apiLogOut();
            $this->outputResult($resp->hasError());
        } catch (Exception $e) {
            $this->outputResult(true);
        }
    }

    /**
     * При необходимости формирования ответа в другом формате метод может быть переопреден в дочериних классах
     * @param $hasError
     */
    public function outputResult($hasError)
    {
        echo $hasError ? "error" : "ok";
    }

}