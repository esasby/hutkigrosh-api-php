<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 15.11.2018
 * Time: 13:02
 */

namespace esas\hutkigrosh\utils;


class ResourceUtils
{
    private static $imageDirUrl;

    public static function getImageUrl($imageFileName)
    {
        if (self::$imageDirUrl == "") {
            self::$imageDirUrl = self::getResourceUrl(dirname(dirname(__FILE__)) . "/image/");
        }
        return self::$imageDirUrl . $imageFileName;
    }

    public static function getResourceUrl($resourcePath)
    {

        $resourceVirtualPath = self::getVirtualPath($resourcePath);
        // server protocol
        $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        // domain name
        $domain = $_SERVER['SERVER_NAME'];
        $doc_root = $_SERVER['DOCUMENT_ROOT'];
        // base url
        $fileUrl = preg_replace("!^${doc_root}!", '', $resourceVirtualPath);
        // на всякий случай удаляем первый слэш
        $fileUrl = preg_replace("!^/!", '', $fileUrl);
        // server port
        $port = $_SERVER['SERVER_PORT'];
        $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
        // put em all together to get the complete base URL
        $url = "${protocol}://${domain}${disp_port}/${fileUrl}";
        return $url; // = http://example.com/path/directory
    }

    private static $real_part;
    private static $virtual_part;

    private static function findSymlink()
    {
        $script_path = $_SERVER["SCRIPT_FILENAME"];
        $script_real_path = realpath($script_path);
        if ($script_path != $script_real_path) {
            for ($script_path_i = strlen($script_path) - 1, $script_real_path_i = strlen($script_real_path) - 1;
                 $script_path_i >= 0 && $script_real_path_i >= 0;
                 $script_path_i--, $script_real_path_i--) {
                if ($script_path[$script_path_i] != $script_real_path[$script_real_path_i]) {
                    self::$real_part = StringUtils::substrBefore($script_real_path, $script_real_path_i + 1);
                    self::$virtual_part = StringUtils::substrBefore($script_path, $script_path_i + 1);
                    return;
                }
            }
        }
    }

    private static function getVirtualPath($path)
    {
        if (self::$real_part == "" || self::$virtual_part == "")
            self::findSymlink();
        return str_replace(self::$real_part, self::$virtual_part, $path);
    }

    public static function getResourceDirUrl($resourcePath)
    {
        return self::getResourceUrl(dirname($resourcePath));
    }

}