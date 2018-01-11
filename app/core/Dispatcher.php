<?php
namespace App\Core;

/**
 * Description of Dispatcher
 *
 * @author Alexandre Bezerra Barbosa
 */
class Dispatcher
{

    private $controller;
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

    public function dispatch()
    {

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
                }
            }

            $params = isset($this->params) ? array_values($this->params) : [];

            call_user_func_array([$controller, $action], $params);
            return TRUE;
        } else if (is_callable($this->controller)) {

            call_user_func($this->controller);
            return TRUE;
        }
    }
}
