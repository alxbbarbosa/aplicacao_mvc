<?php

use App\Facades\Tools;

?>
<html>
    <head>
        <title>Agenda de contatos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../../../public/assets/css/bootstrap.css" type="text/css" rel="stylesheet" />
        <script src="../../../public/assets/js/bootstrap.js" type="text/javascript" ></script>
    </head>
    <body>
        <div class="container">
            <h1>Agenda de Contatos - MVC</h1>
            <hr>
            <div class="panel panel-default" style="margin: 150px;">
                <div class="panel-heading">
                    <span class="panel-title">Confirmar exclusão de registro</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-12"><center>Deseja excluir o contato: "<u><?php echo (isset($nome)) ? $nome : NULL; ?></u>"?</center></label>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="clearfix">
                        <a href="<?php echo isset($id) ? Tools::site_url("contatos/{$id}/excluir") : ''; ?>" class="btn btn-success pull-right"><span class="glyphicon glyphicon-ok"></span> Sim</a>
                        <a class="btn btn-danger pull-left" onclick="javascript:history.go(-1);"><span class="glyphicon glyphicon-remove"></span> Não</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
