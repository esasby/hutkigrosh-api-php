<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 05.03.2019
 * Time: 14:42
 */

namespace esas\hutkigrosh\utils\htmlbuilder;

use esas\hutkigrosh\utils\ArrayUtils;
use esas\hutkigrosh\utils\Logger;
use esas\hutkigrosh\utils\StringUtils;

class ElementVoid
{
    private $name;

    /**
     * @return Attribute[]
     */
    private $attibutes;

    /**
     * ElementVoid constructor.
     * @param $name
     */
    public function __construct($name, array $attibutes = null)
    {
        $this->name = $name;
        if ($attibutes == null)
            return;
        $attibutes = ArrayUtils::flatten($attibutes);
        foreach ($attibutes as $obj) {
            if ($obj instanceof Attribute)
                $this->attibutes[] = $obj;
            else
                Logger::getLogger(get_class($this))->error("Unknown htmlbuilder arg");
        }
    }


    public function __toString()
    {
        return StringUtils::format('<%elementName %attributes/>', [
            "%elementName" => $this->name,
            "%attributes" => ArrayUtils::safeImplode(" ", $this->attibutes)
        ]);
    }
}