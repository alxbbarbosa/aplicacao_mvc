<?php
namespace Framework\Core;

use Framework\Routing\Router;
use Framework\Routing\Request;

class App
{

    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function routing()
    {
        return new Router($this->request);
    }
}
