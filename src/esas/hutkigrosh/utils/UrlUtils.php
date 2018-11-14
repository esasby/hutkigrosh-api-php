<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 14.11.2018
 * Time: 11:28
 */

namespace esas\hutkigrosh\utils;


class UrlUtils
{
    public static function getFileUrl($base_dir)
    {

        $doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', realpath($_SERVER['SCRIPT_FILENAME']));

        // server protocol
        $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';

        // domain name
        $domain = $_SERVER['SERVER_NAME'];

        // base url
        $base_url = preg_replace("!^${doc_root}!", '', $base_dir);

        // server port
        $port = $_SERVER['SERVER_PORT'];
        $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";

        // put em all together to get the complete base URL
        $url = "${protocol}://${domain}${disp_port}${base_url}";

        return $url; // = http://example.com/path/directory
    }

    public static function getDirUrl($file_path)
    {

        return self::getFileUrl(dirname($file_path));
    }
}