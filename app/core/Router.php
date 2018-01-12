<?php
namespace App\Core;

use Exception;
use App\Core\Route;
use App\Core\RouteCollection;
use App\Core\Dispatcher;
use App\Core\Request;
use \ReflectionMethod;

class Router
{

    private $request;

    /**
     * Cria um objeto Request e despacha utilizando um dispatcher
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->dispatch();
    }

    /**
     * Obtém uma Route na Collection com base no método e a URI informada
     * @param type $method
     * @param type $uri
     * @return type Route
     */
    private function getRoute()
    {
        $route = RouteCollection::get($this->request->getMethod(), $this->request->getUri());

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
    public function getParams(Route $route)
    {
        if ($route->hasParam()) {

            $uri = $this->request->getUri();

            $start = $route->getUriWithoutParams();

            return explode('/', substr($uri, strlen($start) + 1, strlen($uri) + 1));
        }
    }

    private function getParamsAction($controller)
    {
        $class = '\App\Controllers\\' . $controller;
        $obj = new $class;
        $rs = new ReflectionMethod($obj, 'salvar');
        $params = $rs->getParameters();

        if (count($params) > 0) {
            foreach ($params as $param) {
                if (method_exists($param->getClass(), 'getName')) {
                    $array[] = [$param->name => $param->getClass()->getName()];
                } else {
                    $array[] = [$param->name => ''];
                }
            }
            return $array;
        }
    }

    private function getParamRequest(array $params)
    {
        foreach ($params as $param) {
            return array_search('App\Core\Request', $param);
        }
    }

    /**
     * Despachar conforme URL informada
     * @param type $method
     * @param type $uri
     */
    private function dispatch()
    {
        //echo 'Em dispatch: ' . $method .' - '. $uri;
        /**
         * Obtém a rota para despachar
         */
        $route = $this->getRoute();

        /**
         * Instanciar um Dispatcher
         */
        $dispatcher = new Dispatcher();

        if ($route->hasController()) {

            $dispatcher->setController($route->getController());
            $dispatcher->setAction($route->getAction());

            switch ($route->getMethod()) {
                case 'GET':
                    if ($route->hasParam()) {
                        $dispatcher->setParams($this->getParams($route));
                    }
                    break;
                case 'POST':

                    $paramsAction = $this->getParamsAction($route->getController());

                    if (count($paramsAction) == 1) {
                        $pRequest = $this->getParamRequest($paramsAction);
                        if ($pRequest) {
                            $dispatcher->setParams([$this->request]);
                        } else {
                            throw New Exception('Parâmetro na Action precisa ser Request');
                        }
                    } else {
                        throw New Exception('Método POST precisa receber apenas um parâmetro');
                    }

                    break;
            }
        } else {
            throw new Exception('Não foi encontrado um controller para rota definida');
        }


        // Dispatcher retornará True ou false
        return $dispatcher->dispatch();
    }
}
