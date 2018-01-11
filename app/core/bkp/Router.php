<?php
namespace App\Core;

use Exception;

class Router
{

    private $uri = [];
    private $controller;
    private $action;
    private $params = [];

    public function add($verb, $uri, $callback = NULL)
    {
        $uri = filter_var(rtrim($uri), FILTER_SANITIZE_URL);

        $this->uri[] = [$verb, $uri, $callback];
    }

    private function parseUrl()
    {
        return (isset($_GET['url'])) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : '/';
    }

    public function call()
    {
        $uri = $this->parseUrl();

        foreach ($this->uri as $uriSaved) {

            if ($uriSaved[0] === $_SERVER['REQUEST_METHOD']) {
                // Url salva nas rotas será divida e trabalhada
                $uW = (strlen($uriSaved[1]) > 1) ? explode('/', trim($uriSaved[1], '/')) : 'Home';
                foreach ($uW as $v) {
                    $f_[] = $v;
                    if (preg_match("/^\{[a-zA-Z_]+\}$/", $v)) {
                        $v_[] = $v;
                        $p_[] = "[a-zA-Z0-9]";
                    } else {
                        $u_[] = $v;
                    }
                }

                // Url - completa
                if (isset($f_)) {
                    $f = implode('/', $f_);
                }

                // Url - primeira parte
                if (isset($u_)) {
                    $u = implode('/', $u_);
                }

                // Url - parte com variáveis
                if (isset($v_)) {
                    $v = implode('/', $v_);
                }

                // Padrão
                // Combinação do padrão
                if (isset($p_)) {
                    $p = implode('/', $p_);
                    $pattern = "#^{$u}\/{$p}$#";
                } else {
                    $pattern = "#^{$u}$#";
                }


                if (preg_match($pattern, (is_array($uri)) ? implode('/', $uri) : $uri)) {

                    if (!is_null($uriSaved[2])) {

                        if (is_string($uriSaved[2])) {
                            $c = explode('@', $uriSaved[2]);

                            // Se o controller existe
                            if (file_exists('../app/controllers/' . $c[0] . '.php')) {
                                $this->controller = $c[0];

                                $controller = '\App\Controllers\\' . $this->controller;
                                $this->controller = new $controller;
                            } else {
                                throw new Exception('Lançado um exceção :: O controller não encontrado: ../app/controllers/' . $c[0] . '.php');
                            }

                            // Verificar se o método existe
                            if (isset($c[1])) {
                                if (method_exists($this->controller, $c[1])) {
                                    $this->action = $c[1];
                                }
                            }

                            // Se foi recebido alguma variável, informar
                            if (isset($v_) && count($v_) > 0) {
                                // Capturar apenas a parte das variáveis
                                for ($i = count($u_); $i < count($f_); $i++) {
                                    $params[] = $uri[$i];
                                }
                            }

                            $this->params = isset($params) ? array_values($params) : [];

                            call_user_func_array([$this->controller, $this->action], $this->params);
                            return TRUE;
                        } else if (is_callable($uriSaved[2])) {

                            call_user_func($uriSaved[2]);
                            return TRUE;
                        }

                        throw new Exception('Lançado um exceção :: Tipo desconhecido foi configurado nas rotas');
                    } else {
                        throw new Exception('Lançado um exceção :: Nenhum controller encontrado');
                    }
                } else {
                    throw new Exception('Lançado um exceção :: Nenhuma rota encontrada');
                }
            } else {
                throw new Exception('Lançado um exceção :: Nenhuma rota definida com o verbo solicitado');
            }
        }
        return FALSE;
    }
}
