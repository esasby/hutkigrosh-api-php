<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 14:28
 */

namespace esas\hutkigrosh\wrappers;


abstract class OrderProductWrapper
{

    /**
     * Артикул товара
     * @return string
     */
    public abstract function getInvId();

    /**
     * Название или краткое описание товара
     * @return string
     */
    public abstract function getName();

    /**
     * Количество товароа в корзине
     * @return mixed
     */
    public abstract function getCount();

    /**
     * Цена за единицу товара
     * @return mixed
     */
    public abstract function getUnitPrice();
}