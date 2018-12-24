<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 06.11.2018
 * Time: 17:08
 */

namespace esas\hutkigrosh\protocol;


use esas\hutkigrosh\utils\StringUtils;

class Amount
{
    private $value;
    private $currency;

    const validCurrencies = array('BYN', 'USD', 'EUR', 'RUB');

    /**
     * Amount constructor.
     * @param $value
     * @param $currency
     */
    public function __construct($value, $currency = null)
    {
        $this->value = $value;
        $this->setCurrency($currency);
    }


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $currency = trim($currency);
        if (!in_array($currency, self::validCurrencies)) {
            $currency = 'BYN';
        }
        $this->currency = $currency;
    }

    public function isEqual(Amount $compTo) {
        if (!StringUtils::compare($this->getCurrency(), $compTo->getCurrency()))
            return false;
        else
            return $this->getValue() == $compTo->getValue();
    }

    public function __toString() {
        return $this->getValue() . " " . $this->getCurrency();
    }
}