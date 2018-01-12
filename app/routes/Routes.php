<?php

use App\Facades\Route;

/**
 * Definição das Rotas
 */
//Route::get('/Home/phone/{id}', 'Home@index');
//Route::get('/Home/phone', 'teste');

Route::get('/', function() {

    echo '<pre>';
    var_dump($_SERVER);
    echo '</pre>';

    $pattern = "#\/[a-zA-Z0-9_]+\/public\/#";
    //$matches = array();
    preg_match($pattern, "/provaDeFogo3/public/teste/", $matches);

    var_dump($matches);
});

Route::get('/contatos/listar', 'ContatosController@listar');

Route::get('/contatos/novo', 'ContatosController@novo');

Route::post('contatos/salvar', 'ContatosController@salvar');
