<?php

use App\Facades\Tools;

?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Agenda de contatos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../assets/css/bootstrap.css" type="text/css" rel="stylesheet" />
        <script src="../assets/js/bootstrap.js" type="text/javascript" ></script>
    </head>
    <body>
        <div class="container">
            <h1>Agenda de Contatos - MVC</h1>
            <hr>

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
                            <td><a class="btn btn-primary" href="novo"><span class="glyphicon glyphicon-plus"></span> Adicionar</a></td>
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