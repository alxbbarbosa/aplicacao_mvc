<?php
namespace App\Core;

use App\Core\Model;

class Controller
{

    public function model($model)
    {
        $model = '\App\Models\\' . $model;
        return new $model;
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
