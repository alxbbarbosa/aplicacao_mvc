<?php
namespace App\Routing;

class Request
{

    private $_BASE_PATH;
    private $_REQUEST_URI;
    private $_REQUEST_VALUES;
    private $_FULL_URI;
    private $_REQUEST_METHOD;
    private $values;

    /**
     * Obter dados de Request
     */
    public function __construct()
    {

        $this->_REQUEST_VALUES = $_REQUEST;
        $this->_REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        $_BASE_PATH = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $_SCRIPT_NAME = explode('/', filter_var(trim($_BASE_PATH, '/'), FILTER_SANITIZE_URL));
        $_REQUEST_URI = explode('/', filter_var(trim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL));
        $_diff = array_diff($_REQUEST_URI, $_SCRIPT_NAME);

        $this->_BASE_PATH = implode('/', $_SCRIPT_NAME);
        $this->_REQUEST_URI = implode('/', $_diff);
        $this->_FULL_URI = $this->_BASE_PATH . '/' . $this->_REQUEST_URI;

        $this->setValuesFromRequest();
    }

    private function setValuesFromRequest()
    {
        $this->values = $this->_REQUEST_VALUES;
    }

    public function getUri()
    {
        return $this->_REQUEST_URI;
    }

    public function getMethod()
    {
        return $this->_REQUEST_METHOD;
    }

    public function __isset($name)
    {
        return isset($this->values[$name]);
    }

    public function __get($name)
    {
        return (isset($this->values[$name])) ? $this->values[$name] : NULL;
    }
}
