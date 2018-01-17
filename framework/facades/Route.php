<?php
namespace Framework\Facades;

use Framework\Routing\Router;
use Framework\Routing\RouteCollection;

class Route
{

    private function __construct()
    {
        
    }

    public static function get($uri, $handler)
    {
        try {
            return RouteCollection::add('GET', $uri, $handler);
        } catch (Exception $e) {
            $c = new SystemController();
            $c->catchException($e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
        }
    }

    public static function post($uri, $handler)
    {
        try {
            return RouteCollection::add('POST', $uri, $handler);
        } catch (Exception $e) {
            $c = new SystemController();
            $c->catchException($e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
        }
    }
}
