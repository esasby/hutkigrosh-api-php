<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 11:59
 */

namespace esas\hutkigrosh\wrappers;

use Throwable;

abstract class OrderWrapper extends Wrapper
{
    /**
     * Уникальный номер заказ в рамках CMS
     * @return string
     */
    public abstract function getOrderId();
    /**
     * Уникальный номер счета в рамках CMS отображаемый клиенту
     * и отправляемый на шлюз
     * (в некоторых CMS может не совпадать с OrderId и поэтому метод может быть переопределен)
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->getOrderId();
    }

    /**
     * Полное имя покупателя
     * @return string
     */
    public abstract function getFullName();

    /**
     * Мобильный номер покупателя для sms-оповещения
     * (если включено администратором)
     * @return string
     */
    public abstract function getMobilePhone();

    /**
     * Email покупателя для email-оповещения
     * (если включено администратором)
     * @return string
     */
    public abstract function getEmail();


    /**
     * Физический адрес покупателя
     * @return string
     */
    public abstract function getAddress();

    /**
     * Общая сумма товаров в заказе
     * @return string
     */
    public abstract function getAmount();

    /**
     * Валюта заказа (буквенный код)
     * @return string
     */
    public abstract function getCurrency();

    /**
     * Массив товаров в заказе
     * @return OrderProductWrapper[]
     */
    public abstract function getProducts();

    /**
     * BillId (идентификатор хуткигрош) успешно выставленного счета
     * @return mixed
     */
    public abstract function getBillId();

    /**
     * Текущий статус заказа в CMS
     * @return mixed
     */
    public abstract function getStatus();

    /**
     * Обновляет статус заказа в БД
     * @param $newStatus
     * @throws Throwable
     * @return mixed
     */
    public abstract function updateStatus($newStatus);

    /**
     * Сохраняет привязку billid к заказу
     * @param $billId
     * @return mixed
     */
    public abstract function saveBillId($billId);
}