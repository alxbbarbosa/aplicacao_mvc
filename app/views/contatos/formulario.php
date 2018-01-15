<?php

use App\Facades\Tools;

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
            <form method="post" action="<?php
            if (isset($localizar)) {
                echo Tools::site_url("contatos/encontre");
            } else {
                echo Tools::site_url("contatos/salvar");
            }

            ?>" class="form-horizontal">
                <div class="panel panel-default" style="margin: 40px;">
                    <div class="panel-heading">
                        <span class="panel-title"><?php
                            if (isset($localizar)) {
                                echo 'Encontrar um contato';
                            } else {
                                echo (isset($id)) ? 'Atualizando cadastro do contato: ' . $nome : 'Cadastrar novo contato';
                            }

                            ?>
                        </span>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="id" value="<?php echo (isset($id)) ? $id : NULL; ?>" />
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nome">Nome:</label>
                            <div class="col-sm-10">
                                <input type="text" name="nome" placeholder="Digite o nome" class="form-control" value="<?php echo (isset($nome)) ? $nome : NULL; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="sobrenome">Sobrenome:</label>
                            <div class="col-sm-10">
                                <input type="text" name="sobrenome" placeholder="Digite o sobrenome" class="form-control" value="<?php echo (isset($sobrenome)) ? $nome : NULL; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">E-mail:</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" placeholder="Digite o E-mail" class="form-control" value="<?php echo (isset($email)) ? $email : NULL; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="telefone">Telefone:</label>
                            <div class="col-sm-10">
                                <input type="text" name="telefone" placeholder="Digite o Telefone" class="form-control" value="<?php echo (isset($telefone)) ? $telefone : NULL; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="celular">Celular:</label>
                            <div class="col-sm-10">
                                <input type="text" name="celular" placeholder="Digite o Celular" class="form-control" value="<?php echo (isset($celular)) ? $celular : NULL; ?>" />
                            </div>
                        </div>


                    </div>
                    <div class="panel-footer">
                        <div class="col-sm-offset-2"><span class="panel-title"><?php
                                if (isset($localizar)) {

                                    ?>
                                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span> Encontre</button>
                                    <?php
                                } else {

                                    ?>
                                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</button>
                                <?php }

                                ?>
                                <button type="reset" name="cancelar" class="btn btn-info" onclick="javascrip:history.go(-1)"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
