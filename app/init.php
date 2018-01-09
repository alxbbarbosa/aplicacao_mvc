<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);


require_once 'core/Loader.php';

\App\Core\Loader::add('App\Core', '../app/core');
\App\Core\Loader::add('App\Controllers', '../app/controllers');
\App\Core\Loader::add('App\Models', '../app/models');

//var_dump(\App\Core\Loader::get());

\App\Core\Loader::register();
