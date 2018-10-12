<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 28.09.2018
 * Time: 13:11
 */

namespace esas\hutkigrosh\wrappers;

use Throwable;

/**
 * Класс-обертка над OrderProductSafeWrapper обеспечивает безопасную загрузку свойств
 * (отлавливаются и логируются исключения, подставляются значения по умолчанию)
 * Class OrderProductSafeWrapper
 * @package esas\hutkigrosh\wrappers
 */
abstract class OrderProductSafeWrapper extends OrderProductWrapper
{

    /**
     * Артикул товара
     * @return string
     */
    public function getInvId()
    {
        try {
            return $this->getInvIdUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get order product invid. Using empty!", $e);
            return "";
        }
    }

    /**
     * Артикул товара
     * @throws Throwable
     * @return string
     */
    public abstract function getInvIdUnsafe();

    /**
     * Название или краткое описание товара
     * @return string
     */
    public function getName()
    {
        try {
            return $this->getNameUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get order product name. Using empty!", $e);
            return "";
        }
    }

    /**
     * Название или краткое описание товара
     * @throws Throwable
     * @return string
     */
    public abstract function getNameUnsafe();

    /**
     * Количество товароа в корзине
     * @return mixed
     */
    public function getCount()
    {
        try {
            return $this->getCountUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get order product caount. Using 0!", $e);
            return "0";
        }
    }

    /**
     * Количество товароа в корзине
     * @throws Throwable
     * @return mixed
     */
    public abstract function getCountUnsafe();

    /**
     * Цена за единицу товара
     * @return mixed
     */
    public function getUnitPrice()
    {
        try {
            return $this->getUnitPriceUnsafe();
        } catch (Throwable $e) {
            $this->logger->error("Can not get order product price. Using 0!", $e);
            return "0";
        }
    }

    /**
     * Цена за единицу товара
     * @throws Throwable
     * @return mixed
     */
    public abstract function getUnitPriceUnsafe();
}