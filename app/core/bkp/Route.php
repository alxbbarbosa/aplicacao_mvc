<?php
namespace App\Core;

class Route
{

    private $uri;
    private $uriArray;
    private $uriPattern;
    private $uriWithoutParams;
    private $method;
    private $controller;
    private $action;
    private $params = [];
    private $callback;

    public function __construct($method, $uri, $controller)
    {
        $this->uri = filter_var($uri, FILTER_SANITIZE_URL);

        $this->parseUri($uri);

        $this->parseParams($uri);

        $this->parseController($controller);
    }

    public function hasParam()
    {
        return (count($this->params) > 0);
    }

    public function getUriWithoutParams()
    {
        return $this->uriWithoutParams;
    }

    public function getUriWithoutParamsArray()
    {
        return explode('/', $this->uriWithoutParams);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getUriAsArray()
    {
        return $this->uriArray;
    }

    public function getController()
    {
        if (!is_null($this->callback)) {
            return $this->callback;
        } else {
            return $this->controller;
        }
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Verificar se uma rota informada casa com o modelo padrão
     * @param type $method
     * @param type $uri
     * @return type
     */
    public function match($method, $uri)
    {
        $method = strtoupper($method);

        return ($this->method === $method && preg_match($this->uriPattern, $uri));
    }

    /**
     * Analisa a Uri e converte para Array
     * @param type $uri
     */
    private function parseUri($uri)
    {
        $this->uriArray = explode('/', filter_var(trim($str, '/'), FILTER_SANITIZE_URL));
    }

    /**
     * Analisa o controller e extrai a action
     * @param type $controller
     */
    private function parseController($controller)
    {
        if (is_scalar($controller) && is_string($controller)) {

            $controller = explode('@', $controller);

            if (count($controller) > 1) {
                $this->controller = $controller[0];
                $this->method = $controller[1];
            } else {
                $this->controller = $controller[0];
                $this->method = 'index';
            }
        } else if (is_callable($controller)) {
            $this->callback = $controller;
        }
    }

    /**
     * Analisa a Uri e extrai os parâmetros
     * @param type $uri
     * @param type $pattern
     * @return void
     */
    private function parseParams($uri, $pattern = "[a-zA-Z0-9]")
    {
        if (count($this->uriArray) > 1) {
            foreach ($this->uriArray as $v) {
                $f_[] = $v;
                /* \verificar se recebeu algum campo como {id} */
                if (preg_match("/^\{[a-zA-Z_]+\}$/", $v)) {
                    $v_[] = $v;
                    $p_[] = $pattern;
                    $this->params[] = [$v, $pattern];
                } else {
                    $u_[] = $v;
                }
            }

            // Url - completa
            $f = (isset($f_)) ? implode('/', $f_) : NULL;

            // Url - primeira parte
            $this->uriWithoutParams = (isset($u_)) ? implode('/', $u_) : NULL;

            // Url - parte com variáveis
            $v = (isset($v_)) ? implode('/', $v_) : NULL;

            // Combinação do padrão
            if (isset($p_)) {
                $p = implode('/', $p_);
                $this->uriPattern = "#^{$this->uriWithoutParams}\/{$p}$#";
            } else {
                $this->uriPattern = "#^{$this->uriWithoutParams}$#";
            }
        }
        return;
    }
}
