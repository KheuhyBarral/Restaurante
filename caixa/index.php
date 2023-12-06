<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isCaixa()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20caixa.');
    }

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Casa Di Fugassa | Restaurante IFNMG</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/cabecario.inq.php")
    ?>
    <main>
      <form action="compra.php" method="get">
        <h2>Registrar nova compra</h2>
        <label for="compraid">Compra(0 para nova compra): </label>
        <input type="number" name="compraid" id="compraid" value="0">  
        <input type="submit" value="Buscar / Criar">
      </form>

      <form action="contascliente.php" method="get">
        <h2>Consutar contas pendentes</h2>
        <input type="submit" value="Buscar cliente">
      </form>

      <form action="historico.php" method="get">
        <h2>Historico de consumo</h2>
        <input type="submit" value="Buscar cliente">
      </form>
      
    </main>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/rodape.inq.php")
    ?>
</body>
</html>