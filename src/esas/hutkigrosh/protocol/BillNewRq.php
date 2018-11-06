<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 12:48
 */

namespace esas\hutkigrosh\protocol;


class BillNewRq extends HutkigroshRq
{
    private $eripId;
    private $invId;
    private $fullName;
    private $mobilePhone;
    private $email;
    private $fullAddress;
    /**
     * @var Amount
     */
    private $amount;
    private $products;
    private $notifyByEMail = false;
    private $notifyByMobilePhone = false;
    private $dueInterval;

    /**
     * @return string
     */
    public function getEripId()
    {
        return $this->eripId;
    }

    /**
     * @param string $eripId
     */
    public function setEripId($eripId)
    {
        $this->eripId = trim($eripId);
    }

    /**
     * @return string
     */
    public function getInvId()
    {
        return $this->invId;
    }

    /**
     * @param string $invId
     */
    public function setInvId($invId)
    {
        $this->invId = trim($invId);
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = trim($fullName);
    }

    /**
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @param string $mobilePhone
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = trim($mobilePhone);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = trim($email);
    }

    /**
     * @return string
     */
    public function getFullAddress()
    {
        return $this->fullAddress;
    }

    /**
     * @param string $fullAddress
     */
    public function setFullAddress($fullAddress)
    {
        $this->fullAddress = trim($fullAddress);
    }

    /**
     * @return Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount(Amount $amount)
    {
        if ($amount == null || $amount->getValue() <= 0)
            $this->logger->warn('Incorrect bill amount[' . $amount->getValue() . "]");
        $this->amount = $amount;
    }

    /**
     * @return BillProduct[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param array $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    public function addProduct(BillProduct $product)
    {
        $this->products[] = $product;
    }

    /**
     * @return bool
     */
    public function isNotifyByEMail()
    {
        return $this->notifyByEMail;
    }

    /**
     * @param bool $notifyByEMail
     */
    public function setNotifyByEMail($notifyByEMail)
    {
        $this->notifyByEMail = $notifyByEMail;
    }

    /**
     * @return bool
     */
    public function isNotifyByMobilePhone()
    {
        return $this->notifyByMobilePhone;
    }

    /**
     * @param bool $notifyByMobilePhone
     */
    public function setNotifyByMobilePhone($notifyByMobilePhone)
    {
        $this->notifyByMobilePhone = $notifyByMobilePhone;
    }

    /**
     * @return mixed
     */
    public function getDueInterval()
    {
        return $this->dueInterval;
    }

    /**
     * @param mixed $dueInterval
     */
    public function setDueInterval($dueInterval)
    {
        $this->dueInterval = $dueInterval;
    }
}
