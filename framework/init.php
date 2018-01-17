<?php
// Habitar modo para debug
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . 'log/error_log.txt');
error_reporting(E_ALL);

// Carregar o Loader
require_once 'core/Loader.php';

// Registrar Namespaces
\Framework\Core\Loader::add('Framework\Core', '../framework/core');
\Framework\Core\Loader::add('Framework\Facade', '../framework/facade');
\Framework\Core\Loader::add('Framework\Routing', '../framework/routing');
\Framework\Core\Loader::add('Framework\Database', '../framework/database');
\Framework\Core\Loader::add('App\Models', '../app/models');
\Framework\Core\Loader::add('App\Controllers', '../app/controllers');


// Registrar classes
\Framework\Core\Loader::register();

try {
// Setar a conexão com o Banco de dados no Model
    \Framework\Core\Model::setConnection(\Framework\Database\Connection::getInstance('../app/config/configdb.ini'));
} catch (Exception $e) {
    $c = new \Framework\Core\SystemController();
    $c->catchException($e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
}
// Carregar as rotas em Collection
require_once '../app/routes/Routes.php';
