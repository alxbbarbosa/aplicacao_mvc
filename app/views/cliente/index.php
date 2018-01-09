<html>
    <head>
        <title>Cliente</title>
    </head>
    <body>
        <ul>
            <h1>Listagem de Clientes - Teste da View</h1>
            <hr>
            <br/>
            <?php
            foreach ($data as $cliente) {

                ?><li>Id: <b><?php echo $cliente->id; ?></b> Nome: <b><?php echo $cliente->nome; ?></b> Endereço: <b><?php echo $cliente->endereco; ?></b></li><?php
            }

            ?>
        </ul>
    </body>
</html>


