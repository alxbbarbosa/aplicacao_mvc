<?php
namespace Framework\Database;

class hasOne
{

    public function __construct($model1, $model2, $local_key, $foreign_key)
    {
        $model1 = env("\App\Models\{$model1}::all()");

        $result = env("\App\Models\{$model2}::all('{$local_key} = {$model1->$foreign_key}')");
    }
}
