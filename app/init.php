<?php
// Habitar modo para debug
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . 'log/error_log.txt');
error_reporting(E_ALL);

// Carregar o Loader
require_once 'core/Loader.php';

// Registrar Namespaces
\App\Core\Loader::add('App\Core', '../app/core');
\App\Core\Loader::add('App\Controllers', '../app/controllers');
\App\Core\Loader::add('App\Models', '../app/models');
\App\Core\Loader::add('App\Database', '../app/database');
\App\Core\Loader::add('App\Facade', '../app/facade');

// Registrar classes
\App\Core\Loader::register();

// Setar a conexão com o Banco de dados no Model
App\Core\Model::setConnection(App\Database\Connection::getInstance('../app/config/configdb.ini'));

// Carregar as rotas em Collection
require_once 'routes/Routes.php';