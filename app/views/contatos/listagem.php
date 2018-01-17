<?php

use \Framework\Facades\Tools;

?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Agenda de contatos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo Tools::site_url('assets/css/bootstrap.css'); ?>" type="text/css" rel="stylesheet" />
        <script src="<?php echo Tools::site_url('assets/js/bootstrap.js'); ?>" type="text/javascript" ></script>
    </head>
    <body>
        <div class="container">
            <h1>Agenda de Contatos - MVC</h1>
            <hr>
            <form action="<?php echo Tools::site_url("contatos/encontre"); ?>" method="post" class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="encontrar" class="control-label col-sm-1">Encontrar:</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" name="encontrar" class="form-control" placeholder="Encontrar um contato ..." />
                                    <span class="input-group-btn">
                                        <button class="btn btn-info">Encontre</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <a href="<?php echo Tools::site_url("contatos/formbusca"); ?>" class="btn btn-default">Formulário de busca</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="panel panel-default">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>id</td>
                            <td>Nome</td>
                            <td>Sobrenome</td>
                            <td>Email</td>
                            <td>Telefone</td>
                            <td>Celular</td>
                            <td><a class="btn btn-primary" href="<?php echo Tools::site_url("contatos/novo"); ?>"><span class="glyphicon glyphicon-plus"></span> Adicionar</a></td>
                            <td><button class="btn btn-default"><span class="glyphicon glyphicon-log-out"></span> Voltar</button></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contatos as $contato) { ?>
                            <tr>
                                <td><?php echo $contato->id; ?></td>
                                <td><?php echo $contato->nome; ?></td>
                                <td><?php echo $contato->sobrenome; ?></td>
                                <td><?php echo $contato->email; ?></td>
                                <td><?php echo $contato->telefone; ?></td>
                                <td><?php echo $contato->celular; ?></td>
                                <td><a href="<?php echo Tools::site_url("contatos/{$contato->id}"); ?>" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Alterar</a></td>
                                <td><a href="<?php echo Tools::site_url("contatos/{$contato->id}/confirmar"); ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Excluir</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>