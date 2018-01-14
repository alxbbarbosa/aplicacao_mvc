<?php
namespace App\Core;

use App\Routing\Router;
use App\Routing\Request;

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
