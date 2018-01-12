<?php
namespace App\Core;

use App\Core\Router;
use App\Core\Request;

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
