<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 06.06.2018
 * Time: 14:21
 */

namespace esas\hutkigrosh\controllers;


use esas\hutkigrosh\Logger;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;

abstract class Controller
{

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var ConfigurationWrapper
     */
    protected $configurationWrapper;

    /**
     * Controller constructor.
     * @param Logger $logger
     */
    public function __construct(ConfigurationWrapper $configurationWrapper)
    {
        $this->configurationWrapper = $configurationWrapper;
        $this->logger = $logger;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }


}