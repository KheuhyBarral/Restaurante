<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isCaixa()){
      header('Location:/logIn.php?errormessage=Você%20não%20é%20caixa.');
    }
    if(!isset($_GET["compraid"]))
    {
      header('Location:/caixa');
    }else{
      require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php";

      $compra = Compra::getCompra($_GET["compraid"]);
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
        <div>
          <form action="finalizarcompra.php" method="get">
          <input type="hidden" name="compraid" value="<?php echo $_GET["compraid"]?>">
            <label for="cliente">ClienteId(0 para venda a vista):</label><input type="number" name="cliente" id="cliente" value="<?php echo isset($_GET["cliente"]) ? $_GET["cliente"] : "0"?>">
            <input type="submit" value="Buscar">
          </form>
          <?php
          if(isset($_GET["cliente"]) && $_GET["cliente"] != 0){
            echo "<h2>Cliente: ";
            echo Util::getClient($_GET["cliente"]);
            echo "</h2>";
          }else{
            echo "<h2>Venda a vista</h2>";
          }
          ?>
        </div>
        <div>
          <h3>Valor:  <?php 
          echo "R$ " . number_format($compra->valor, 2, ",", ".");        
          ?>
          </h3>
        </div>
        <div>
          <?php
          if(isset($_GET["valorpago"])){
            echo '<form action="finalizarcompra.php" method="get">
            <input type="hidden" name="compraid" value="' . $_GET["compraid"] . '">
            <label for="valorpago">Valor pago: </label><input type="number" name="valorpago" id="valorpago" step="0.01" value="'. $_GET["valorpago"] . '">
            <input type="hidden" name="cliente" value="'. $_GET["cliente"] . '">
            <br>
            <input type="submit" value="Verificar troco">
            </form>';
            if($_GET["valorpago"] - $compra->valor >= 0){
              echo "<h3>Troco: R$ ". number_format(round($_GET["valorpago"] - $compra->valor, 2), 2, ",", ".") ."</h3>";
            }else{
              echo "<h3>Pendente: R$ ". number_format(round(($_GET["valorpago"] - $compra->valor)*-1, 2), 2, ",", ".") ."</h3>";
            }
          
          }
          else {
          echo '<form action="finalizarcompra.php" method="get">
            <input type="hidden" name="compraid" value="' . $_GET["compraid"] . '">
            <label for="valorpago">Valor pago: </label><input type="number" name="valorpago" id="valorpago" step="0.01" value="'. $compra->valor . '">
            <input type="hidden" name="cliente" value="'. $_GET["cliente"] . '">
            <br>
            <input type="submit" value="Verificar troco">
          </form>';
          }

          if(isset($_GET["cliente"]) && isset($_GET["valorpago"])){
            if($_GET["valorpago"] >= $compra->valor){
              echo '<form action="finishsell.php" method="post">
              <input type="hidden" name="compraid" value="' . $_GET["compraid"] . '">
              <input type="hidden" name="cliente" value="'. $_GET["cliente"] . '">
              <input type="hidden" name="valorpago" id="valorpago" value="'. $_GET["valorpago"] . '">
              <input type="submit" value="Finalizar compra">
    
              </form>';
            }
            else if($_GET["cliente"] != 0 && Util::isCarteira($_GET["cliente"])){
              echo '<form action="finishsell.php" method="post">
              <input type="hidden" name="compraid" value="' . $_GET["compraid"] . '">
              <input type="hidden" name="cliente" value="'. $_GET["cliente"] . '">
              <input type="hidden" name="valorpago" id="valorpago" value="'. $_GET["valorpago"] . '">
              <br>
              <label for="pin">PIN(4 dígitos): </label> <input type="password" name="pin" id="pin" maxlength="4" minlength="4">
              <br>
              <input type="submit" value="Finalizar compra">
    
              </form>';
            }
          }
          ?>
          
          
        </div>
    </main>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/rodape.inq.php")
    ?>
</body>
</html>