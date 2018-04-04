<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 14:16
 */

namespace esas\hutkigrosh\protocol;


class BillProduct
{
    private $invId;
    private $name;
    private $count;
    private $unitPrice;

    /**
     * @return mixed
     */
    public function getInvId()
    {
        return $this->invId;
    }

    /**
     * @param mixed $invId
     */
    public function setInvId($invId)
    {
        $this->invId = trim($invId);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = trim($name);
    }

    /**
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param float $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

}