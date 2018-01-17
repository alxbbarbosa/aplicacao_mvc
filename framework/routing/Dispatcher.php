<?php
namespace Framework\Routing;

use Exception;
use \ReflectionMethod;
use Framework\Routing\Route;
use Framework\Core\SystemController;

/**
 * Classe Dispatcher: gera um objeto despachante que recebe uma rota
 * encontrada pela classe roteadora, então lê os dados  encapsulados
 * referente ao controller, action e  parâmetros  a  serem  passados
 * como argumentos na action invocada.
 *
 * @author Alexandre Bezerra Barbosa
 */
class Dispatcher
{

    private $route;
    private $controller = 'home';
    private $action = 'index';
    private $params = [];

    public function __construct(Route $route)
    {
        $this->route = $route;

        if ($route->hasController()) {

            $this->setController($route->getController());
            $this->setAction($route->getAction());
            if ($route->hasParam()) {
                $this->setParams($route->getMethod());
            }
        } else {
            throw new Exception('Não foi encontrado um controller para rota definida');
        }
    }

    private function setController($controller)
    {
        $this->controller = $controller;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function setParams(string $method)
    {
        switch ($method) {
            case 'GET':
                $this->params = $this->getParams();
                break;
            case 'POST':

                $params = $this->getParamsAction();

                if (count($params) == 1) {

                    $paramRequest = $this->getParamRequest($params);

                    if ($paramRequest) {

                        $this->params = $paramRequest;
                    } else {
                        throw New Exception('Parâmetro na Action precisa ser Request');
                    }
                } else {
                    throw New Exception('Método POST precisa receber apenas um parâmetro');
                }
                break;
        }
    }

    private function mergeParams($array)
    {
        if (!is_array($array)) {
            return FALSE;
        }
        $rs = array();
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $rs = array_merge($rs, $this->mergeParams($v));
            } else {
                $rs[$k] = $v;
            }
        }
        return $rs;
    }

    /**
     * Verificar se possui parâmetros, obter
     * @return type array
     */
    private function getParams()
    {
        if ($this->route->hasParam()) {

            return $this->route->getParams();
        }
    }

    private function getParamsAction()
    {
        $class = '\App\Controllers\\' . $this->controller;
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
     * Este método faz os despacho para o Controller responsável, invocando seu método
     * e passando parâmetros como argumentos.
     * 
     * @return boolean
     * @throws Exception
     */
    public function dispatch()
    {

        try {
            if (is_string($this->controller)) {

                // Se o controller existe
                if (file_exists('../app/controllers/' . $this->controller . '.php')) {

                    $controller = '\App\Controllers\\' . $this->controller;
                    $controller = new $controller;
                } else {
                    throw new Exception('Lançado um exceção :: O controller não encontrado: ../app/controllers/' . $this->controller . '.php');
                }

                // Verificar se o método existe
                if (isset($this->action)) {
                    if (method_exists($controller, $this->action)) {
                        $action = $this->action;
                    } else {
                        throw new Exception('Action não encontrado para o Controller!');
                    }
                }

                if (isset($this->params)) {

                    foreach ($this->params as $param) {
                        $params[] = [$param['param'] => $param['value']];
                    }
                    if (isset($params)) {
                        $this->params = $this->mergeParams($params);
                    }
                } else {
                    $this->params = [];
                }
                call_user_func_array([$controller, $action], array_values($this->params));
                return TRUE;
            } else if (is_callable($this->controller)) {
                call_user_func($this->controller);
                return TRUE;
            } else {
                throw new Exception('Impossível chamar controller!');
            }
        } catch (Exception $e) {
            $c = new SystemController();
            $c->catchException($e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
        }
    }
}
