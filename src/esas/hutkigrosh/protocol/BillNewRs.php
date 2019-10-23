<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 15:38
 */

namespace esas\hutkigrosh\protocol;


class BillNewRs extends HutkigroshRs
{
    /**
     * @var string
     */
    private $billId;

    /**
     * @return string
     */
    public function getBillId()
    {
        return $this->billId;
    }

    /**
     * @param string $billId
     */
    public function setBillId($billId)
    {
        $this->billId = trim($billId);
    }

}