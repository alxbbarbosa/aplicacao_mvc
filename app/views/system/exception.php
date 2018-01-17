<?php

use Framework\Facades\Tools;

?>
<html>
    <head>
        <title>Exceção!</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo Tools::site_url() ?>../vendor/bootstrap/dist/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <script src="<?php echo Tools::site_url() ?>../vendor/bootstrap/dist/js/bootstrap.js" type="text/javascript" ></script>
    </head>
    <body>
        <div class="container">
            <h1><span class="glyphicon glyphicon-exclamation-sign"></span> Capturado uma Exceção</h1>
            <hr>
            <div class="panel panel-default" style="margin-top: 100px; margin-right: 20px; margin-left: 20px;">
                <div class="panel-heading">
                    <span class="panel-title"><span class="glyphicon glyphicon-remove-circle"></span> Um problema ocorreu e foi lançado uma Exceção! - Code: <?php echo $code; ?></span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="panel panel-default">
                            <div class="panel-body alert-danger">
                                <label class="col-sm-12"><span class="glyphicon glyphicon-hand-right"></span> <?php echo $mensagem; ?>
                                    <br />
                                    <br />
                                    Problema disparado na Linha <u><?php echo $line; ?></u> do arquivo: <u><?php echo $file; ?></u>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12"><br />
                            <span class="glyphicon glyphicon-screenshot"></span> Rastreio:
                            <br /><pre><?php
                                echo $tracer;

                                ?></pre>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>