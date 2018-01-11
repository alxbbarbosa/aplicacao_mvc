<?php
namespace App\Core;

use App\Core\Route;

class RouteCollection
{

    private static $routes = [];

    /**
     * Adicionar uma rota
     * @param type $method
     * @param type $uri
     * @param type $handler
     */
    public static function add(string $method, string $uri, $handler = NULL)
    {
        $method = strtoupper($method);

        if (preg_match("/^(GET|POST|PUT|DELETE)$/", $method)) {
            self::$routes[] = new Route($method, $uri, $handler);
        }
    }

    /**
     * Obter uma das rotas
     * @param type $method
     * @param type $uri
     * @return type Route
     */
    public static function get(string $method, string $uri)
    {
        foreach (self::$routes as $route) {
            if ($route->match($method, $url)) {
                return $route;
            }
        }
        return;
    }
}
