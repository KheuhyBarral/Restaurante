<div>
  <?php
  require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";

  $compras = Compra::comprasDeventesCliente($_GET["id"]);

  echo "<h2>Dívidas do ". Util::getClient($_GET["id"]) ."</h2>";
  
  $r = "<table><tr>
      <th>Data</th>
      <th>Vendedor</th>
      <th>Valor total</th>
      <th>Valor pago</th>
      <th>Dívida</th>
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
    $r .= "<td>R$ " . number_format($divida,2,",",".") . "</td> </tr>"; 
  }
  $r .= "<td>Total</td>
  <td></td>
  <td></td>
  <td></td>
  <td>R$ " . number_format($total,2,",",".") ."</td> </table>";
  echo $r;
  ?>

  <form action="/admin/paydebts.php" method="post">
    <input type="hidden" name="cliente" value="<?php echo $_GET["id"] ?>">
    <label for="valor">Valor(R$): </label><input type="number" name="valor" step="0.01" id="valor" value="<?php echo $total ?>" max="<?php echo $total ?>">
    <input type="submit" value="Quitar">
  </form>
</div>