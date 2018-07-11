<?php

namespace esas\hutkigrosh\lang;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 09.07.2018
 * Time: 11:51
 */
class Translator
{
    /**
     * Translator constructor.
     */
    public static function translate($msg, $locale)
    {
        $file = __DIR__ . "/" . $locale . ".php";
        if (!file_exists($file)) {
            $file = __DIR__ . "/ru_RU.php";
        }
        $lang = include $file;
        $translation = $lang[$msg];
        return !empty($translation) ? $translation : $msg;
    }
}