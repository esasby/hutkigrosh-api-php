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

class IncludeFile
{
    private $scriptFileLocation;
    private $scriptData;
    private $logger;

    /**
     * Script constructor.
     * @param $scriptFileLocation
     * @param $scriptData
     */
    public function __construct($scriptFileLocation, $scriptData)
    {
        $this->scriptFileLocation = $scriptFileLocation;
        $this->scriptData = $scriptData;
        $this->logger = Logger::getLogger(get_class($this));
    }


    public function __toString()
    {
        $ret = "";
        try {
            ob_start();
            include ($this->scriptFileLocation);
            $ret = ob_get_clean();
        } catch (Throwable $e) {
            $this->logger->error("Exception:", $e);
        } catch (Exception $e) { // для совместимости с php 5
            $this->logger->error("Exception:", $e);
        }
        return $ret;
    }


}