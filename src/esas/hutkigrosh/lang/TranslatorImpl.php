<?php

namespace esas\hutkigrosh\lang;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 09.07.2018
 * Time: 11:51
 */
class TranslatorImpl extends Translator
{
    private $lang;

    protected function loadLocale($locale)
    {
        if (null == $this->lang[$locale]) {
            $file = __DIR__ . "/" . $locale . ".php";
            if (!file_exists($file)) {
                $code = substr($locale, 0, 2);
                $file = __DIR__ . "/" . $code . "_" . strtoupper($code) . ".php";
                if (!file_exists($file))
                    $file = __DIR__ . "/ru_RU.php";
            }
            $this->lang[$locale] = include $file;
        }
    }

    /**
     * Translator constructor.
     */
    public function translate($msg, $locale = null)
    {
        if (null == $locale)
            $locale = $this->getLocale();
        $locale = $this->formatLocaleName($locale);
        $this->loadLocale($locale);
        if (array_key_exists($msg, $this->lang[$locale]))
            return $this->lang[$locale][$msg];
        else
            return $msg;
    }

    /**
     * Locale по умолчанию, может быть переопределен
     * @return string
     */
    public function getLocale()
    {
        return Locale::ru_RU;
    }

    /**
     * Перобразует имя локали из формата CMS, во внутренний формат (ru_RU, en_EN ...)
     * @param $locale
     * @return string
     */
    public function formatLocaleName($locale)
    {
        return $locale;
    }

}