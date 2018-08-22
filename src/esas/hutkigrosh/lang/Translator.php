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
    private $lang;

    protected function loadLocale($locale) {
        if (null == $this->lang[$locale]) {
            $file = __DIR__ . "/" . $locale . ".php";
            if (!file_exists($file)) {
                $file = __DIR__ . "/ru_RU.php";
            }
            $this->lang[$locale] = include $file;
        }
    }
    /**
     * Translator constructor.
     */
    public function translate($msg, $locale = null) {
        if (null == $locale)
            $locale = $this->getLocale();
        $this->loadLocale($locale);
        $translation = $this->lang[$locale][$msg];
        return !empty($translation) ? $translation : $msg;
    }

    public function getConfigFieldName($key, $locale = null) {
        return $this->translate($key, $locale);
    }

    public function getConfigFieldDescription($key, $locale = null) {
        return $this->translate($key . "_desc", $locale);
    }

    public function getConfigFieldDefault($key, $locale = null) {
        return $this->translate($key . "_default", $locale);
    }

    /**
     * Locale по умолчанию, может быть переопределен
     * @return string
     */
    public function getLocale() {
        return Locale::ru_RU;
    }

}