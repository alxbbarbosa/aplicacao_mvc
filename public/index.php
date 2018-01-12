<?php

// Inicializar
require_once '../app/init.php';

// Instanciar App
$app = new \App\Core\App;

// Rotear
$app->routing();
