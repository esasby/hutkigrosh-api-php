<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 02.10.2018
 * Time: 14:59
 */

namespace esas\hutkigrosh;


use esas\hutkigrosh\utils\Logger;
use esas\hutkigrosh\utils\SimpleAutoloader;

/**
 * Class CmsPlugin позволяет удобно настроить и проинициализировать все служебные объекты, неоьходимые для работы core.
 * Пример использования для CMS Opencart:
 * (new CmsPlugin())
 *      ->setCmsPluginDir(dirname(dirname(dirname(__FILE__))))
 *      ->setComposerVendorDir(dirname(dirname(__FILE__)) . '/vendor')
 *      ->setRegistry(new RegistryOpencart())
 *      ->init();
 * @package esas\hutkigrosh
 */
class CmsPlugin
{
    private $composerVendorDir;
    private $cmsPluginDir;
    /**
     * @var Registry
     */
    private $registry;

    /**
     * CmsPlugin constructor.
     * @param $composerVendorDir
     * @param $cmsPluginDir
     */
    public function __construct($composerVendorDir, $cmsPluginDir)
    {
        if (substr($composerVendorDir, -1) == '/')
            $composerVendorDir = substr($composerVendorDir, 0, -1);
        $this->composerVendorDir = $composerVendorDir;
        $this->cmsPluginDir = $cmsPluginDir;
        require_once($this->composerVendorDir . '/autoload.php');
        SimpleAutoloader::register($this->cmsPluginDir);
    }

    /**
     * @param Registry $registry
     * @return CmsPlugin
     */
    public function setRegistry($registry)
    {
        $this->registry = $registry;
        return $this;
    }

    public function init($logLevel = 'INFO')
    {
        Logger::init($logLevel);
        $this->registry->init();
    }

}