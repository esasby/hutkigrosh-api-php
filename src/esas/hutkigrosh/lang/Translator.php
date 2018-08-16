<?php

namespace esas\hutkigrosh\lang;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 09.07.2018
 * Time: 11:51
 */
abstract class Translator
{
    /**
     * Translator constructor.
     */
    public function translate($msg)
    {
        $file = __DIR__ . "/" . $this->getLocale() . ".php";
        if (!file_exists($file)) {
            $file = __DIR__ . "/ru_RU.php";
        }
        $lang = include $file;
        $translation = $lang[$msg];
        return !empty($translation) ? $translation : $msg;
    }

    public function getConfigFieldName($key) {
        return $this->translate($key);
    }

    public function getConfigFieldDescription($key) {
        return $this->translate($key . "_desc");
    }

    public function getConfigFieldDefault($key) {
        return $this->translate($key . "_default");
    }

    public abstract function getLocale();
}