<?php
namespace App\Controllers;

use App\Core\Controller;

class ContatosController extends Controller
{

    public function listar()
    {
        $contatos = \App\Models\Contato::all();

        $this->view('contatos.listagem', ['contatos' => $contatos]);
    }
}
