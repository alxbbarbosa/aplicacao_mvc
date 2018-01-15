<?php
namespace App\Core;

use App\Core\Model;
use App\Core\View;

class Controller
{

    public function goPage(string $page)
    {
        $base = implode('/', array_slice(explode('/', parse_url($_SERVER['SCRIPT_NAME'])['path']), 0, -1));
        $goPage = $base . '/' . trim($page, '/');
        header("Location: {$goPage}");
        exit();
    }

    public function model($model)
    {
        try {
            $model = '\App\Models\\' . $model;
            return new $model;
        } catch (Exception $e) {
            $c = new SystemController();
            $c->catchException($e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
        }
    }

    public function view($view, $data = [])
    {
        try {
            $viewer = new View();
            $viewer->render($view, $data);
        } catch (Exception $e) {
            $c = new SystemController();
            $c->catchException($e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
        }
    }
}
