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
    <div>
  <?php
  require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";

  if(isset($_GET["id"])){

    $compras = Compra::comprasDeventesCliente($_GET["id"]);
    echo '<a href="contascliente.php"><input type="submit" value="Voltar"></a>';
    echo "<h2>Dívidas do ". Util::getClient($_GET["id"]) ."</h2>";
    
    $r = "<table><tr>
        <th>Data</th>
        <th>Vendedor</th>
        <th>Valor total</th>
        <th>Valor pago</th>
        <th>Dívida</th>
        <th>Detalhes</th>
        </tr>";
    
    $total = 0;
    foreach($compras as $c)
    {
      $data = $c->data;
      $vendedor = Util::getClient($c->vendedor_id);
      $valor_total = $c->valor;
      $valor_pago = $c->valor_pago;
      $divida = $valor_total - $valor_pago;
      $total += $divida;
      
      $r .= "<tr> <td>" . $data . "</td>"; 
      $r .= "<td>" . $vendedor . "</td>"; 
      $r .= "<td>R$ " . number_format($valor_total,2,",",".") . "</td>"; 
      $r .= "<td>R$ " . number_format($valor_pago,2,",",".") . "</td>"; 
      $r .= "<td>R$ " . number_format($divida,2,",",".") . "</td> "; 
      $r .= "<td><a href='/detalhescompra.php?id=" . $c->id . "'> <img src=\"/img/lapis.svg\"></a></td></tr>";
    }
    $r .= "<td>Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td>R$ " . number_format($total,2,",",".") ."</td><td></td></table>";
    echo $r;

    echo '<form action="/caixa/paydebts.php" method="post">
    <input type="hidden" name="cliente" value="'. $_GET["id"] . '">
    <label for="valor">Valor(R$): </label><input type="number" name="valor" step="0.01" id="valor" value="'. $total.'" max="'. $total . '">
    <input type="submit" value="Quitar">
    </form>';


  
  }else{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php";
    echo '<a href="index.php"><input type="submit" value="Voltar"></a>';
    echo "<h2>Clientes</h2>";

    echo Compra::clientesDeventes();
  }

  ?>

</div>
    </main>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/rodape.inq.php")
    ?>
</body>
</html>