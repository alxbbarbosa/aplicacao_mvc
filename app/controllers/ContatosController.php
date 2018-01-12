<?php
namespace App\Controllers;

use App\Core\Controller;

class ContatosController extends Controller
{

    public function salvar()
    {
        echo 'OK';
        
        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';
    }

    public function novo()
    {
        $this->view('contatos.formulario');
    }

    public function listar()
    {
        $contatos = \App\Models\Contato::all();

        $this->view('contatos.listagem', ['contatos' => $contatos]);
    }
}
