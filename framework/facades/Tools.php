<?php
namespace Framework\Facades;

/**
 * Description of Tools
 *
 * @author alexandre
 */
class Tools
{

    public static function site_url(string $path = '')
    {
        $scheme = $_SERVER['REQUEST_SCHEME'];
        $server = $_SERVER['SERVER_NAME'];
        $port = $_SERVER['SERVER_PORT'];
        $base = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1));
        return "{$scheme}://{$server}:{$port}{$base}/$path";
    }
}
