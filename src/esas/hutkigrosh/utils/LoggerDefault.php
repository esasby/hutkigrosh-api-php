<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.08.2018
 * Time: 7:35
 */

namespace esas\hutkigrosh\utils;


use Exception;
use Logger;

class LoggerDefault
{
    public static function init()
    {
        $dir = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/logs';
        self::createSafeDir($dir);
        Logger::configure(array(
            'rootLogger' => array(
                'appenders' => array('fileAppender'),
                'level' => 'INFO',
            ),
            'appenders' => array(
                'fileAppender' => array(
                    'class' => 'LoggerAppenderFile',
                    'layout' => array(
                        'class' => 'LoggerLayoutPattern',
                        'params' => array(
                            'conversionPattern' => '%date{Y-m-d H:i:s,u} | %logger{0} | %-5level | %msg %n%throwable',
                        )
                    ),
                    'params' => array(
                        'file' => $dir . '/hutkigrosh.log',
                        'append' => true
                    )
                )
            )
        ));
    }

    /**
     * Создает директорию с файлом .htaccess
     * Для ограничения доступа из вне к файлам логов
     * @param $dirname
     * @throws Exception
     */
    private static function createSafeDir($dirname)
    {
        if (!is_dir($dirname) && !mkdir($dirname)) {
            throw new Exception("Can not create log dir[" . $dirname . "]");
        }
        $file = $dirname . '/.htaccess';
        if (!file_exists($file)) {
            $content =
                '<Files *.log>' .
                'Order allow,deny' .
                'Deny from all' .
                '</Files>';
            file_put_contents($file, $content);
        }
    }
}