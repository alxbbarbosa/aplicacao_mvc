<?php
namespace App\Core;

class Request
{

    private $uri;
    private $method;
    private $elements;

    /**
     * Obter dados de Request
     */
    public function __construct()
    {
        // Não vai funcionar para este Framework
        $uri = $_SERVER['REQUEST_URI'];
        $match = array();
        preg_match("#\/[a-zA-Z0-9_]+\/public\/#", $uri, $match);
        $size = strlen($match[0]);
        
        if ($size > 0) {
            $newUri = substr($uri, $size, strlen($uri));
            $this->uri = (strlen($newUri) > 1) ? $newUri : '/';
        } else {
            $this->uri = $uri;
        }

        $this->method = $_SERVER['REQUEST_METHOD'];

        switch ($this->method) {
            case 'POST':
                $this->elements = $_POST;
                break;
            case 'GET':
                $this->elements = $this->parseUrl();
                break;
        }
    }

    private function parseUrl()
    {
        return (isset($this->uri)) ? explode('/', filter_var(rtrim($this->uri, '/'), FILTER_SANITIZE_URL)) : '/';
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
        return (isset($this->elements[$name])) ? $this->elements[$name] : NULL;
    }
}
