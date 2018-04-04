<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 12:50
 */

namespace esas\hutkigrosh\protocol;


class WebPayRq extends HutkigroshRq
{
    private $billId;
    private $returnUrl;
    private $cancelReturnUrl;

    /**
     * @return mixed
     */
    public function getBillId()
    {
        return $this->billId;
    }

    /**
     * @param mixed $billId
     */
    public function setBillId($billId)
    {
        $this->billId = $billId;
    }

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @param mixed $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * @return mixed
     */
    public function getCancelReturnUrl()
    {
        return $this->cancelReturnUrl;
    }

    /**
     * @param mixed $cancelReturnUrl
     */
    public function setCancelReturnUrl($cancelReturnUrl)
    {
        $this->cancelReturnUrl = $cancelReturnUrl;
    }


}