<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isCliente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20cliente.');
    }

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Casa Di Fugassa | Restaurante IFNMG</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/cabecario.inq.php")
    ?>
    <main>
        CLIENTE
    </main>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/rodape.inq.php")
    ?>
</body>
</html>