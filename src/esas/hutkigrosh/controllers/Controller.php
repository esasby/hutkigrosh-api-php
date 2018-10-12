<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 06.06.2018
 * Time: 14:21
 */

namespace esas\hutkigrosh\controllers;


use esas\hutkigrosh\Registry;
use esas\hutkigrosh\utils\Logger;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;

abstract class Controller
{
    /**
     * @var ConfigurationWrapper
     */
    protected $configurationWrapper;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Controller constructor.
     */
    public function __construct(ConfigurationWrapper $configurationWrapper = null)
    {
        $this->logger = Logger::getLogger(get_class($this));
        if ($configurationWrapper != null)
            $this->configurationWrapper = $configurationWrapper;
        else
            $this->configurationWrapper = Registry::getRegistry()->getConfigurationWrapper();
    }

}