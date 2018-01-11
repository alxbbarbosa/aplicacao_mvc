<?php

use App\Facades\Route;

/**
 * Definição das Rotas
 */

//Route::get('/Home/phone/{id}', 'Home@index');

//Route::get('/Home/phone', 'teste');

Route::get('/contatos/listar', 'ContatosController@listar');
