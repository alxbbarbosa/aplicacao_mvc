<?php
namespace Framework\Routing;

/**
 * Classe Request: Gera o objeto de requisição (encapsula uma requisição) conforme
 * dados coletados das super variáveis globais. Este objeto será lido pela  objeto
 * roteador que procurará uma rota na coleção com base na Uri encapsulada.
 * 
 * @author Alexandre Bezerra Barbosa
 */
class Request
{

    private $_BASE_PATH;
    private $_REQUEST_URI;
    private $_REQUEST_VALUES;
    private $_FULL_URI;
    private $_REQUEST_METHOD;

    public function __construct()
    {
        $_BASE_PATH = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $_SCRIPT_NAME = explode('/', filter_var(trim($_BASE_PATH, '/'), FILTER_SANITIZE_URL));
        $_REQUEST_URI = explode('/', filter_var(trim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL));
        $this->_BASE_PATH = implode('/', $_SCRIPT_NAME);
        $this->_REQUEST_URI = implode('/', array_diff($_REQUEST_URI, $_SCRIPT_NAME));
        $this->_FULL_URI = $this->_BASE_PATH . '/' . $this->_REQUEST_URI;
        $this->_REQUEST_VALUES = $_REQUEST;
        $this->_REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
    }

    public function getUri(): string
    {
        return $this->_REQUEST_URI;
    }

    public function getMethod(): string
    {
        return $this->_REQUEST_METHOD;
    }

    public function __isset($key): bool
    {
        return isset($this->_REQUEST_VALUES[$key]);
    }

    public function __get($key): ?string
    {
        return (isset($this->_REQUEST_VALUES[$key])) ? $this->_REQUEST_VALUES[$key] : NULL;
    }
}
