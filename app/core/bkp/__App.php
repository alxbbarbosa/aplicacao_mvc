<?php
include_once 'Route.php';
include_once 'Teste.php';

class App
{

    public function __construct()
    {
        $route = new Route();

        //$route->add('/');
        $route->add('/home', function () {
            echo 'This is home';
        });
        $route->add('/contact', 'Teste');
        $route->add('/about', 'a');

        echo '<pre>';
        print_r($route);
        echo '</pre>';

        $route->call();
    }
}
