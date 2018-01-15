<?php
namespace App\Routing;

use Exception;
use App\Routing\Route;
use App\Routing\RouteCollection;
use App\Routing\Dispatcher;
use App\Routing\Request;
use App\Core\SystemController;
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
            $c = new SystemController();
            $c->index();
            //throw new Exception('Não foi encontrado uma rota definida para esta Uri');
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

            return $route->getParams();
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
                    $array[] = ['param' => $param->name, 'type' => $param->getClass()->getName()];
                } else {
                    $array[] = ['param' => $param->name];
                }
            }
            return $array;
        }
    }

    private function getParamRequest(array $params)
    {
        foreach ($params as $k => $param) {
            if (array_search('App\Routing\Request', $param)) {
                $params[$k]['value'] = $this->request;
                return $params;
            }
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
        try {
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

                        $params = $this->getParamsAction($route->getController());

                        if (count($params) == 1) {

                            $paramRequest = $this->getParamRequest($params);

                            if ($paramRequest) {

                                $dispatcher->setParams($paramRequest);
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
        } catch (Exception $e) {

            $c = new SystemController();
            $c->catchException($e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
        }
    }
}
