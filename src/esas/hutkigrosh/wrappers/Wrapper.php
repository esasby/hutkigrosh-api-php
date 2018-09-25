<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 24.09.2018
 * Time: 15:55
 */

namespace esas\hutkigrosh\wrappers;


use esas\hutkigrosh\lang\Translator;
use esas\hutkigrosh\utils\Logger;

abstract class Wrapper
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * Wrapper constructor.
     */
    public function __construct(Translator $translator)
    {
        $this->logger = Logger::getLogger(get_class($this));
        $this->translator = $translator;
    }
}