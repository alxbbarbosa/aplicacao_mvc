<?php
namespace App\Core;

use Exception;
use App\Core\Route;
use App\Core\RouteCollection;
use App\Core\Dispatcher;
use App\Core\Request;

class Router
{

    private static $collection;

    public function __construct()
    {
        $request = new Request();

        $this->dispatch($request->getMethod(), $request->getUri());
    }

    public static function setCollection(RouteCollection $collection)
    {
        self::$collection = $collection;
    }

    /**
     * Obtém uma rota conforme se informar o método e a URI
     * @param type $method
     * @param type $uri
     * @return type Route
     */
    private function getRoute($method, $uri)
    {
        return Router::$collection->get($method, $uri);
    }

    /**
     * Verificar se possui parâmetros, obter
     * @param Route $route
     * @param type $url
     * @return type array
     */
    public function getParams(Route $route, $url)
    {
        if ($route->hasParam()) {

            $start = $route->getUriWithoutParams();

            return explode('/', substr($url, count($start) - 1, count($url)));
        }
    }

    /**
     * Despachar conforme URL informada
     * @param type $method
     * @param type $uri
     */
    private function dispatch($method, $uri)
    {
        $dispatcher = new Dispatcher();

        $route = $this->getRoute($method, $uri);

        $dispatcher->setController($route->getController());
        $dispatcher->setAction($route->getAction());
        $dispatcher->setParams($this->getParams($route, $url));

        $dispatcher->dispatch();
    }
}
