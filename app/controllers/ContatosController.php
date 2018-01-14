<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Routing\Request;

class ContatosController extends Controller
{

    public function salvar(Request $request)
    {

        $contato = $this->model('Contato');
        $contato->salvar($request);

        $this->goPage('contatos/listar');
    }

    public function novo()
    {
        $this->view('contatos.formulario');
    }

    public function editar($id)
    {
        $contato = $this->model('Contato');

        $contato = $contato->carregar($id);

        $this->view('contatos.formulario', [
            'id' => $contato->id,
            'nome' => $contato->nome,
            'sobrenome' => $contato->sobrenome,
            'email' => $contato->email,
            'telefone' => $contato->telefone,
            'celular' => $contato->celular,
        ]);
    }

    public function listar()
    {
        $contatos = \App\Models\Contato::all();

        $this->view('contatos.listagem', ['contatos' => $contatos]);
    }

    public function confirmarExcluir($id)
    {
        $contato = $this->model('Contato');

        $c = $contato->carregar($id);

        $this->view('contatos.confirmar', ['id' => $c->id, 'nome' => $c->nome]);
    }

    public function excluir($id)
    {

        $contato = $this->model('Contato');

        $c = $contato->carregar($id);

        $c->delete();

        $this->goPage('contatos/listar');
    }
}
