<?php
namespace App\Models;

use App\Core\Model;

class Contato extends Model
{

    protected $table = 'tb_contatos';
    protected $logTimestamp = FALSE;

    public function salvar($request)
    {
        if (isset($request->id) && $request->id !== "") {
            $this->id = $request->id;
        }
        $this->nome = isset($request->nome) ? $request->nome : NULL;
        $this->sobrenome = isset($request->sobrenome) ? $request->sobrenome : NULL;
        $this->email = isset($request->email) ? $request->email : NULL;
        $this->telefone = isset($request->telefone) ? $request->telefone : NULL;
        $this->celular = isset($request->celular) ? $request->celular : NULL;

        $this->save();
    }

    public function carregar($id)
    {
        $contato = Contato::find($id);

        return $contato;
    }
}
