<?php
namespace App\Core;

use App\Core\Router;

class App
{

    private static $router;

    public function __construct()
    {
        App::$router->call();
    }

    public static function setRouter($router)
    {
        self::$router = $router;
    }
}
