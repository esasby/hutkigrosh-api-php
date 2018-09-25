<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 24.09.2018
 * Time: 17:06
 */

namespace esas\hutkigrosh\lang;

abstract class Translator
{
    public abstract function translate($msg, $locale = null);

    public function getConfigFieldName($key, $locale = null) {
        return $this->translate($key, $locale);
    }

    public function getConfigFieldDescription($key, $locale = null) {
        return $this->translate($key . "_desc", $locale);
    }

    public function getConfigFieldDefault($key, $locale = null) {
        return $this->translate($key . "_default", $locale);
    }
}