<?php

use \Framework\Facades\Tools;

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>404 - Página não encontrada</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo Tools::site_url() ?>../vendor/bootstrap/dist/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <script src="<?php echo Tools::site_url() ?>../vendor/bootstrap/dist/js/bootstrap.js" type="text/javascript" ></script>
    </head>
    <body style="background-color: #dd3333; color: #ffffff;">
        <div class="container">
            <section>
                <article>
                    <header>
                        <h1><span class="glyphicon glyphicon-exclamation-sign"></span> Erro 404</h1>
                    </header>
                    <hr>
                    <div class="panel panel-default" style="margin: 150px;">
                        <div class="panel-heading">
                            <span class="panel-title"><span class="glyphicon glyphicon-remove-circle"></span>  Erro 404: Página não foi encontrada!</span>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="panel panel-default">
                                    <div class="panel-body alert-danger">
                                        <label class="col-sm-12"><center><span class="glyphicon glyphicon-hand-right"></span> A URL que você requisitou ou, a página que você está tentando acessar não pode ser encontrada!</center></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </div>
    </body>
</html>

