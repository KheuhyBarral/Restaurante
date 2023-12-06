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
      <h2>Detalhes da compra</h2>
      <?php
      if(isset($_GET["id"])){
        require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php";
       
        echo Compra::detalhesCompra($_GET["id"]);    
      }

      ?>
      <button onclick="window.history.back()">Voltar</button>

    </main>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/rodape.inq.php")
    ?>
</body>
</html>