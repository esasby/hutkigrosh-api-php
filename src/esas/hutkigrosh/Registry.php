<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 11:35
 */

namespace esas\hutkigrosh;


use esas\hutkigrosh\lang\Translator;
use esas\hutkigrosh\utils\Logger;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;
use esas\hutkigrosh\wrappers\OrderWrapper;

/**
 * Реализация шаблона registry для удобства доступа к $configurationWrapper и $translator.
 * В каждой CMS должен быть обязательно наследован и проинициализирован через Registry->init()
 * Class Registry
 * @package esas\hutkigrosh
 */
abstract class Registry
{
    private $configurationWrapper;
    private $translator;

    public function init() {
        global $esasRegistry;
        if ($esasRegistry == null) {
            Logger::getLogger(get_class($this))->info("init");
            $esasRegistry = $this;
        }
    }

    /**
     * @return ConfigurationWrapper
     */
    public function getConfigurationWrapper()
    {
        if ($this->configurationWrapper == null)
            $this->configurationWrapper = $this->createConfigurationWrapper();
        return $this->configurationWrapper;
    }
    
    public abstract function createConfigurationWrapper();

    /**
     * @return Translator
     */
    public function getTranslator()
    {
        if ($this->translator == null)
            $this->translator = $this->createTranslator();
        return $this->translator;
    }

    public abstract function createTranslator();

    public static function getRegistry() {
        /**
         * @var \esas\hutkigrosh\Registry $esasRegistry
         */
        global $esasRegistry;
        if ($esasRegistry == null) {
            Logger::getLogger("registry")->fatal("Esas registry is not initialized!");
        }
        return $esasRegistry;
    }

    /**
     * По локальному номеру счета (номеру заказа) возвращает wrapper
     * @param $orderId
     * @return OrderWrapper
     */
    public abstract function getOrderWrapper($orderNumber);
}