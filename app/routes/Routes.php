<?php

use App\Facades\Route;

/**
 * Definição das Rotas
 */
//Route::get('/Home/phone/{id}', 'Home@index');
//Route::get('/Home/phone', 'teste');

Route::get('/', function() {

    $this->goPage('/contatos/listar');
    
});

Route::get('/contatos/listar', 'ContatosController@listar');

Route::get('/contatos/novo', 'ContatosController@novo');

Route::get('/contatos/{id}', 'ContatosController@editar');

Route::get('/contatos/{id}/confirmar', 'ContatosController@confirmarExcluir');

Route::get('/contatos/{id}/excluir', 'ContatosController@excluir');

Route::post('/contatos/salvar', 'ContatosController@salvar');