<!doctype html>
<html lang="pt-br">
    <head>
        <title>Agenda de contatos</title>
        <meta charset="utf-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../assets/css/bootstrap.css" type="text/css" rel="stylesheet" />
        <script src="../assets/js/bootstrap.js" type="text/javascript" ></script>
    </head>
    <body>
        <div class="container">
            <h1>Agenda de Contatos - MVC</h1>
            <hr>
            <form method="post" class="form-horizontal">
                <div class="panel panel-default" style="margin: 40px;">
                    <div class="panel-heading">
                        <span class="panel-title"><?php echo (isset($id)) ? 'Atualizando cadastro do contato: ' . $nome : 'Cadastrar novo contato'; ?></span>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="id" value="<?php echo (isset($id)) ? $id : ''; ?>" />
                        <div class="form-group">
                            <label class="col-sm-2" for="nome">Nome:</label>
                            <div class="col-sm-10">
                                <input type="text" name="nome" placeholder="Digite o nome" class="form-control" value="<?php echo (isset($nome)) ? $nome : ''; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2" for="sobrenome">Sobrenome:</label>
                            <div class="col-sm-10">
                                <input type="text" name="sobrenome" placeholder="Digite o sobrenome" class="form-control" value="<?php echo (isset($sobrenome)) ? $nome : ''; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2" for="email">E-mail:</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" placeholder="Digite o E-mail" class="form-control" value="<?php echo (isset($email)) ? $email : ''; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2" for="telefone">Telefone:</label>
                            <div class="col-sm-10">
                                <input type="text" name="telefone" placeholder="Digite o Telefone" class="form-control" value="<?php echo (isset($telefone)) ? $telefone : ''; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2" for="celular">Celular:</label>
                            <div class="col-sm-10">
                                <input type="text" name="celular" placeholder="Digite o Celular" class="form-control" value="<?php echo (isset($celular)) ? $celular : ''; ?>" />
                            </div>
                        </div>


                    </div>
                    <div class="panel-footer">
                        <div class="col-sm-offset-2">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</button>
                            <button name="cancelar" class="btn btn-info"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </body>
</html>
