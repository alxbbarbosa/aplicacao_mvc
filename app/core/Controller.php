<?php
namespace App\Core;

use App\Models\Model;

class Controller
{

    public function model($model)
    {
        $model = '\App\Models\\' . $model;
        return new $model;
    }

    public function view($view, $data = [])
    {
        require_once '../app/views/' . $view . '.php';
    }
}
