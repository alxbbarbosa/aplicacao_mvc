<?php

use App\Facades\Route;

/**
 * Definição das Rotas
 */
Route::get('/', function() {

    $this->goPage('/contatos/listar');
});

Route::get('/contatos/listar', 'ContatosController@listar');

Route::get('/contatos/novo', 'ContatosController@novo');

Route::get('/contatos/formbusca', 'ContatosController@formbusca');

Route::get('/contatos/{id}', 'ContatosController@editar')->define(['id' => 'int']);

Route::get('/contatos/{id}/confirmar', 'ContatosController@confirmarExcluir')->define(['id' => 'int']);

Route::get('/contatos/{id}/excluir', 'ContatosController@excluir')->define(['id' => 'int']);

Route::post('/contatos/salvar', 'ContatosController@salvar');
