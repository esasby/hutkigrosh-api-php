<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 21.06.2019
 * Time: 10:57
 */

namespace esas\hutkigrosh\utils\htmlbuilder;

use esas\hutkigrosh\utils\Logger;
use Exception;
use Throwable;

/**
 * Class ReadContentFile для чтения содержимого файла без запуска php обработчика.
 * Используется для чтения CSS файлов или, например, файлов javascript-ов, не содержащих php-блоки.
 * Содержимое файла попадет в конечный html "как есть"
 * @package esas\hutkigrosh\utils\htmlbuilder
 */
class ReadContentFile
{
    private $file;
    private $logger;

    /**
     * ReadContentFile constructor.
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
        $this->logger = Logger::getLogger(get_class($this));
    }


    public function __toString()
    {
        try {
            if ("" == $this->file)
                return "";
            if (file_exists($this->file))
                return file_get_contents($this->file);
            else
                $this->logger->error("Can not read content from file " . $this->file);
        } catch (Throwable $e) {
            $this->logger->error("Exception:", $e);
        } catch (Exception $e) { // для совместимости с php 5
            $this->logger->error("Exception:", $e);
        }
        return "";
    }
}