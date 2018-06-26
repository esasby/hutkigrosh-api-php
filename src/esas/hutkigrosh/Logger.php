<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 05.06.2018
 * Time: 14:40
 */

namespace esas\hutkigrosh;


use Throwable;

abstract class Logger
{
    public abstract function error($message, Throwable $e = null);

    public abstract function info($message);

    public abstract function debug($message);
}