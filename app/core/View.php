<?php
namespace App\Core;

use Exception;

class View
{

    public function render($view, $data = [])
    {

        $view = str_replace('.', '/', $view);

        $filename = '../app/views/' . $view . '.php';

        if (!file_exists($filename)) {
            throw new Exception("A view não pode ser renderizada. Arquivo <u>{$filename}</u> não encontrado.");
        }

        ob_start();
        /**
         * Gerar variáveis automaticamente
         */
        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                ${$k} = $v;
            }
        }

        require_once $filename;
        ob_end_flush();
    }
}
