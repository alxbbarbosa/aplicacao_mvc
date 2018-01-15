<?php
namespace App\Routing;

use Exception;
use App\Core\SystemController;

/**
 * Description of Dispatcher
 *
 * @author Alexandre Bezerra Barbosa
 */
class Dispatcher
{

    private $controller = 'home';
    private $action = 'index';
    private $params = [];

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
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
