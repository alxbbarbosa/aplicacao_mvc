<?php
namespace App\Controllers;

use App\Core\Controller;

class ClientesController extends Controller
{

    public function index()
    {
        $cliente = $this->model('Cliente');
        $lista = $cliente->listarRecentes();
        
        $this->view('cliente/index', $lista);
    }
}
