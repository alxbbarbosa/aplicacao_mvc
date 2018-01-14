<?php
namespace App\Core;

use App\Core\Model;

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
        ob_start();
        /**
         * Gerar variáveis automaticamente
         */
        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                ${$k} = $v;
            }
        }

        $view = str_replace('.', '/', $view);

        require_once '../app/views/' . $view . '.php';
        ob_end_flush();
    }
}
