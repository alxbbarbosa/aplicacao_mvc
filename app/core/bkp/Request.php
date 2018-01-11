<?php
namespace App\Core;

class Request
{

    private $uri;
    private $method;
    private $elements;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];

        switch ($this->method) {
            case 'POST':
                $this->elements = $_POST[];
                break;
            case 'GET':
                $this->elements = $this->parseUrl();
                break;
        }
    }

    private function parseUrl()
    {
        return (isset($_GET['url'])) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : '/';
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function __isset($name)
    {
        return isset($this->elements[$name]);
    }

    public function __get($name)
    {
        return (isset($this->$name)) ? $this->$name : '';
    }
}
