<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 27.09.2018
 * Time: 13:16
 */

namespace esas\hutkigrosh\wrappers;


use Throwable;

/**
 * Класс-обертка над OrderWrapper обеспечивает безопасную загрузку свойств 
 * (отлавливаются и логируются исключения, подставляются значения по умолчанию)
 * Class OrderSafeWrapper
 * @package esas\hutkigrosh\wrappers
 */
abstract class OrderSafeWrapper extends OrderWrapper
{

    /**
     * Уникальный номер заказ в рамках CMS
     * @return string
     * @throws Throwable
     */
    public function getOrderId()
    {
        try {
            return $this->getOrderIdUnsafe();
        } catch (Throwable $e) {
            $this->logger->fatal("Can not get order id!", $e);
            throw $e;
        }
    }

    /**
     * Уникальный номер заказ в рамках CMS
     * @return string
     * @throws Throwable
     */
    public abstract function getOrderIdUnsafe();

    /**
     * Полное имя покупателя
     * @return string
     */
    public function getFullName()
    {
        try {
            return $this->getFullNameUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get full name from order. Using empty!", $e);
            return "";
        }
    }

    /**
     * Полное имя покупателя
     * @throws Throwable
     * @return string
     */
    public abstract function getFullNameUnsafe();

    /**
     * Мобильный номер покупателя для sms-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getMobilePhone()
    {
        try {
            return $this->getMobilePhoneUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get mobile phone from order. Using empty!", $e);
            return "";
        }
    }

    /**
     * Мобильный номер покупателя для sms-оповещения
     * (если включено администратором)
     * @throws Throwable
     * @return string
     */
    public abstract function getMobilePhoneUnsafe();
    
    /**
     * Email покупателя для email-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getEmail()
    {
        try {
            return $this->getEmailUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get email from order. Using empty!", $e);
            return "";
        }
    }

    /**
     * Email покупателя для email-оповещения
     * (если включено администратором)
     * @throws Throwable
     * @return string
     */
    public abstract function getEmailUnsafe();

    /**
     * Физический адрес покупателя
     * @return string
     */
    public function getAddress()
    {
        try {
            return $this->getAddressUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get address from order. Using empty!", $e);
            return "";
        }
    }

    /**
     * Физический адрес покупателя
     * @throws Throwable
     * @return string
     */
    public abstract function getAddressUnsafe();
    
    /**
     * Общая сумма товаров в заказе
     * @return string
     */
    public function getAmount()
    {
        try {
            return $this->getAmountUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get amount from order. Using 0!", $e);
            return "0";
        }
    }

    /**
     * Общая сумма товаров в заказе
     * @throws Throwable
     * @return string
     */
    public abstract function getAmountUnsafe();

    /**
     * Валюта заказа (буквенный код)
     * @return string
     */
    public function getCurrency()
    {
        try {
            return $this->getCurrencyUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get currency from order. Using BYN!", $e);
            return "BYN";
        }
    }

    /**
     * Валюта заказа (буквенный код)
     * @throws Throwable
     * @return string
     */
    public abstract function getCurrencyUnsafe();

    private $orderProducts;
    
    /**
     * Массив товаров в заказе
     * @return OrderProductWrapper[]
     */
    public function getProducts()
    {
        try {
            if ($this->orderProducts == null)
                $this->orderProducts = $this->getProductsUnsafe();
            return $this->orderProducts;
        } catch (Throwable $e) {
            $this->logger->error("Can not get products from order. Using empty list!", $e);
            return [];
        }
    }

    /**
     * Массив товаров в заказе
     * @throws Throwable
     * @return OrderProductWrapper[]
     */
    public abstract function getProductsUnsafe();
    
    /**
     * BillId (идентификатор хуткигрош) успешно выставленного счета
     * @return mixed
     */
    public function getBillId()
    {
        try {
            return $this->getBillIdUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get billid from order. Using empty!", $e);
            return "";
        }
    }

    /**
     * BillId (идентификатор хуткигрош) успешно выставленного счета
     * @throws Throwable
     * @return mixed
     */
    public abstract function getBillIdUnsafe();

    /**
     * Текущий статус заказа в CMS
     * @return mixed
     * @throws Throwable
     */
    public function getStatus()
    {
        try {
            return $this->getStatusUnsafe();
        } catch (Throwable $e) {
            $this->logger->fatal("Can not get status from order!", $e);
            throw $e;
        }
    }

    /**
     * Текущий статус заказа в CMS
     * @return mixed
     * @throws Throwable
     */
    public abstract function getStatusUnsafe();

    /**
     * Обновляет статус заказа в БД
     * @param $newStatus
     * @return mixed
     */
}