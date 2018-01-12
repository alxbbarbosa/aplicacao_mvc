<?php
namespace App\Facades;

use App\Core\Router;
use App\Core\RouteCollection;

class Route
{

    private function __construct()
    {
        
    }

    public static function get($uri, $handler)
    {
        RouteCollection::add('GET', $uri, $handler);
    }

    public static function post($uri, $handler)
    {
        RouteCollection::add('POST', $uri, $handler);
    }
}
