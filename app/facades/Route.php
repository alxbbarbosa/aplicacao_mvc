<?php
namespace App\Facades;

use App\Core\Router;

class Route
{

    private static $router;

    private function __construct()
    {
        
    }

    public static function getRouter()
    {
        if (is_null(self::$router)) {
            self::$router = new Router();
        }
        return self::$router;
    }

    public static function get($uri, $callback)
    {
        self::getRouter()->add('GET', $uri, $callback);
    }

    public static function post($uri, $callback)
    {
        self::getRouter()->add('POST', $uri, $callback);
    }
}
