<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
    include("../base/cabecario.inq.php")
    ?>
    <main>
        
        <a href="cadastrousuarios.php">
            <button>Criar Usuário</button>
        </a>
        <?php

        require_once("../classes/Util.class.php");
        echo Util::tabelaAdmin();
        ?>

        

    </main>
    <?php
    include("../base/rodape.inq.php")
    ?>
</body>
</html>