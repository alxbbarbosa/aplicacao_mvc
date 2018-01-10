<?php
namespace App\Core;

class App
{

    private $uri = [];
    private $controllers = [];
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        $controller = '\App\Controllers\\' . $this->controller;

        $this->controller = new $controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    public function add($uri, $callback = NULL)
    {
        $this->uri[] = $uri;

        if ($callback != NULL) {
            $this->controllers[$uri] = $callback;
        }
    }
}
