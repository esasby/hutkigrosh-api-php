<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 06.06.2018
 * Time: 14:21
 */

namespace esas\hutkigrosh\controllers;


use esas\hutkigrosh\wrappers\ConfigurationWrapper;

abstract class Controller
{
    /**
     * @var ConfigurationWrapper
     */
    protected $configurationWrapper;

    /**
     * Controller constructor.
     */
    public function __construct(ConfigurationWrapper $configurationWrapper)
    {
        $this->configurationWrapper = $configurationWrapper;
    }

}