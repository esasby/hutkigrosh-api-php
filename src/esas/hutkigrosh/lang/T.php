<?php

namespace esas\hutkigrosh\lang;

use Zend\I18n\Translator\Translator;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 09.07.2018
 * Time: 11:51
 */
class T
{
    /**
     * Translator constructor.
     * @param $translator
     * @return Translator
     */
    public static function getTranslator()
    {
        $translator = new Translator();
        $translator->addTranslationFilePattern("phparray", __DIR__, '%s.php');
        return $translator;
    }


}