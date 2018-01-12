<?php
namespace App\Core;

use Exception;
use App\Core\Route;
use App\Core\RouteCollection;
use App\Core\Dispatcher;
use App\Core\Request;

class Router
{

    /**
     * Cria um objeto Request e despacha utilizando um dispatcher
     */
    public function __construct(Request $request)
    {
        $this->dispatch($request->getMethod(), $request->getUri());
    }

    /**
     * Obtém uma Route na Collection com base no método e a URI informada
     * @param type $method
     * @param type $uri
     * @return type Route
     */
    private function getRoute($method, $uri)
    {
        //echo '<br />Em getRoute: ' . $method . ' - ' . $uri . '<br />';

        $route = RouteCollection::get($method, $uri);
        
        if (!is_null($route)) {
            return $route;
        } else {
            throw new Exception('Não foi encontrado uma rota definida para esta Uri');
        }
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
        //echo 'Em dispatch: ' . $method .' - '. $uri;
        /**
         * Obtém a rota para despachar
         */
        $route = $this->getRoute($method, $uri);

        /**
         * Instanciar um Dispatcher
         */
        $dispatcher = new Dispatcher();

        if ($route->hasController()) {

            $dispatcher->setController($route->getController());
            $dispatcher->setAction($route->getAction());

            if ($route->hasParam()) {
                $dispatcher->setParams($this->getParams($route, $uri));
            }
        } else {
            throw new Exception('Não foi encontrado um controller para rota definida');
        }


        // Dispatcher retornará True ou false
        return $dispatcher->dispatch();
    }
}
