<?php

namespace esas\hutkigrosh\controllers;

use esas\hutkigrosh\protocol\AlfaclickRq;
use esas\hutkigrosh\protocol\HutkigroshProtocol;
use Exception;
use Throwable;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 11:30
 */
class ControllerAlfaclick extends Controller
{
    public function process($billId, $phone)
    {
        try {
            $loggerMainString = "Bill[" . $billId . "]: ";
            $this->logger->info($loggerMainString . "Controller started");
            if (empty($billId) || empty($phone))
                throw new Exception('Wrong billid[' . $billId . "] or phone[" . $phone . "]");
            $hg = new HutkigroshProtocol($this->configurationWrapper);
            $resp = $hg->apiLogIn();
            if ($resp->hasError()) {
                $hg->apiLogOut();
                throw new Exception($resp->getResponseMessage(), $resp->getResponseCode());
            }
            $alfaclickRq = new AlfaclickRq();
            $alfaclickRq->setBillId($billId);
            $alfaclickRq->setPhone($phone);

            $resp = $hg->apiAlfaClick($alfaclickRq);
            $hg->apiLogOut();
            $this->outputResult($resp->hasError());
            $this->logger->info($loggerMainString . "Controller ended");
        } catch (Throwable $e) {
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
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