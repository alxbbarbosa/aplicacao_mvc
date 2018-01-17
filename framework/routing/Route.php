<?php
namespace Framework\Routing;

use Exception;
use Framework\Facades\Tools;
use Framework\Core\SystemController;
use Framework\Routing\RouteController;

/**
 * Classe Route: Encapsula uma rota contendo a Uri como padrão informado pelo
 * usuário, o Controller e a Action. Além disso, irá capturar  os  parâmetros
 * conforme o padrão definido pelo usuário.
 * 
 * @author Alexandre Bezerra Barbosa
 */
class Route
{

    private $uri;
    private $userUri;
    private $uriArray;
    private $uriPattern;
    private $uriWithoutParams;
    private $method;
    private $controller;
    private $action;
    private $params = [];
    private $callback;
    private $tipos = [];

    public function __construct(string $method, string $uri, $handler)
    {
        $this->uri = Tools::site_url(filter_var(trim($uri, '/'), FILTER_SANITIZE_URL));

        $method = strtoupper($method);
        if (preg_match("/^(GET|POST|PUT|DELETE)$/", $method)) {
            $this->method = $method;
        } else {
            throw new Exception('Erro: tentativa de criar uma rota com um método inválido.');
        }

        try {
            $this->parseUri($uri);
            $this->parseParams($uri);
            $this->parseController($handler);
        } catch (Exception $e) {
            $c = new SystemController();
            $c->catchException($e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
            exit();
        }
    }

    public function define(array $tipos)
    {
        foreach ($tipos as $key => $value) {
            if (is_string($key)) {
                if (preg_match("/^(int|string|bool)$/", $value)) {

                    switch ($value) {
                        case 'int':
                            $pattern = "[0-9]{1,}";
                            break;
                        case 'string':
                            $pattern = "[a-zA-Z0-9]{1,}";
                            break;
                        case 'bool':
                            $pattern = "(TRUE|FALSE|true|false|0|1)";
                            break;
                        default :
                            throw new Exception("Tipo informado para variável <u>{$value}</u> da URI não é válido.");
                    }
                    $this->parseParams($this->userUri, $pattern, $key);
                } else {
                    throw new Exception('Tipo de variável é inválido');
                }
            } else {
                throw new Exception('Nome de variável é inválido');
            }
        }
    }

    public function hasParam()
    {
        return (count($this->params) > 0);
    }

    public function hasController()
    {
        return (!is_null($this->controller) || !is_null($this->callback));
    }

    public function getParams()
    {
        return $this->params;
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
        } else if (!is_null($this->controller)) {
            return $this->controller;
        }
        return;
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
     * @param type $method - Ex: GET, POST
     * @param type $uri
     * @return type bool / Exception
     */
    public function match(string $method, string $uri)
    {
        $uri = Tools::site_url($uri);
        $method = strtoupper($method);
        if ($this->method === $method && preg_match($this->uriPattern, $uri)) {

            // Preenche também os valores nos dos campos
            foreach ($this->params as $key => $param) {
                $paramName = $param['param'];

                $c = array_keys(preg_grep("/\{$paramName\}/", array_values(explode('/', $this->uri))));

                $this->params[$key]['value'] = explode('/', $uri)[$c[0]];
            }
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Analisa a Uri e converte para Array
     * @param type $uri
     */
    private function parseUri($uri)
    {
        $this->uriArray = explode('/', filter_var(trim($uri, '/'), FILTER_SANITIZE_URL));
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
                $this->action = $controller[1];
            } else {
                $this->controller = $controller[0];
                $this->action = 'index';
            }
        } else if (is_callable($controller)) {
            $this->callback = $controller->bindTo(new RouteController());
        }
    }

    /**
     * Analisa a Uri e extrai os parâmetros
     * @param type $uri
     * @param type $pattern
     * @return void
     */
    private function parseParams($uri, $pattern = NULL, $var = NULL)
    {
        $this->userUri = $uri;
        if ($uri !== '/') {
            if (count($this->uriArray) > 1) {
                $index = 0;
                foreach ($this->uriArray as $v) {
                    /* \verificar se recebeu algum campo como {id} */
                    if (preg_match("/^\{[a-zA-Z_]+\}$/", $v)) {
                        $paramName = str_replace('{', '', str_replace('}', '', $v));
                        if (!is_null($var) && $var === $paramName) {
                            $this->params[] = ['param' => $var, 'pattern' => $pattern];
                        } else {
                            $pattern = "[a-zA-Z0-9]{1,}";
                            $this->params[] = ['param' => $paramName, 'pattern' => $pattern];
                        }
                        $fp_[$index] = $pattern;
                    } else {
                        $fp_[$index] = $v;
                    }
                    $index++;
                }

                $fp = isset($fp_) ? implode('/', $fp_) : NULL;
                $fp = Tools::site_url($fp);
                $this->uriPattern = str_replace('/', '\/', "#^{$fp}$#");
            }
        } else {
            $this->uriPattern = "#^\/$#";
        }
        return;
    }
}
