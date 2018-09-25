<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 12:47
 */

namespace esas\hutkigrosh\protocol;

use esas\hutkigrosh\utils\Logger;

class HutkigroshRq
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * HutkigroshRq constructor.
     */
    public function __construct()
    {
        $this->logger = Logger::getLogger(get_class($this));
    }
}