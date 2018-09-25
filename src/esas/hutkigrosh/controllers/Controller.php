<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 06.06.2018
 * Time: 14:21
 */

namespace esas\hutkigrosh\controllers;


use esas\hutkigrosh\lang\Translator;
use esas\hutkigrosh\utils\Logger;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;

abstract class Controller
{
    /**
     * @var ConfigurationWrapper
     */
    protected $configurationWrapper;

    /**
     * @var TranslatorImpl
     */
    protected $translator;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Controller constructor.
     */
    public function __construct(ConfigurationWrapper $configurationWrapper, Translator $translator = null)
    {
        $this->logger = Logger::getLogger(get_class($this));
        $this->configurationWrapper = $configurationWrapper;
        $this->translator = $translator;
    }

}