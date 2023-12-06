<?php

class Compra{
  public static function addProduto($compraid, $produtoid, $quantidade) {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['caixa'] == true) {
      require_once("r.class.php");

      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
    
      $compra = R::findOne("compras", ' id = ? ' ,[$compraid]);

      $i = R::dispense("itens");

      $i->produto = R::findOne("produtos",' id = ? ' ,[$produtoid]); 
      $i->quantidade = $quantidade;

      $compra->ownItensList[] = $i;
    
      R::store($compra);

      R::close();
      
      header('Location:/caixa/compra.php?message=Produto%20adicionado!.&compraid=' . $compraid . '&produtoid=' . $produtoid);
    }else{
      header('Location:/logIn.php?errormessage=Você%20não%20é%20caixa.');
    }
    
    
    
  }
  
  public static function listaProdutos($id){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['caixa'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
      
      $compra = R::findOne("compras", ' id = ? ',[$id]);

      if($compra->id == 0){
        $compra = R::dispense("compras");
        
        date_default_timezone_set('America/Sao_Paulo');
        $compra->data = date('d/m/Y H:i:s');
        
        $compra->vendedor = R::findOne("users", ' email = ? ', [$_SESSION["email"]]);

        $compra->comprador_id = 0;

        $id = R::store($compra);        
        
        header('Location:/caixa/compra.php?message=Compra%20criada!.&compraid=' . $id);
      }


      $itens = R::findAll("itens", ' compras_id = ? ',[$id]);

      $produtos = R::findAll("produtos");
      $r = "<table><tr>
                <th>Descrição</th>
                <th>Valor Unitário</th>
                <th>Quantidade</th>
                <th>Valor</th>
            </tr>";
      $total = 0;
      foreach ($itens as $i) {
        $total += $produtos[$i->produto_id]->valor * $i->quantidade;
        $r = $r .
          "<tr>
          <td>" . $produtos[$i->produto_id]->descricao . "</td>" .
          "<td> R$ " . $produtos[$i->produto_id]->valor . "</td>" .
          "<td>" . $i->quantidade . "</td>" .
          "<td> R$ " .  number_format($produtos[$i->produto_id]->valor * $i->quantidade, 2, ',', '.') . "</td> </tr>" ;
        
      }
      $r = $r .
          "<tr>
          <td> Total  </td>" .
          "<td></td>" .
          "<td></td>" .
          "<td>R$ "  . number_format($total, 2, ',', '.'). "</td> </tr>" ;
      
      $r = $r . "</table>";

      return $r;

    }else{
      header('Location:/logIn.php?errormessage=Você%20não%20é%20caixa.');
    }
  }

  public static function detalhesCompra($id){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['cliente'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
      
      $compra = R::findOne("compras", ' id = ? ',[$id]);

      $itens = R::findAll("itens", ' compras_id = ? ',[$id]);

      $produtos = R::findAll("produtos");
      $r = "<table><tr>
                <th>Descrição</th>
                <th>Valor Unitário</th>
                <th>Quantidade</th>
                <th>Valor</th>
            </tr>";
      $total = 0;
      foreach ($itens as $i) {
        $total += $produtos[$i->produto_id]->valor * $i->quantidade;
        $r = $r .
          "<tr>
          <td>" . $produtos[$i->produto_id]->descricao . "</td>" .
          "<td> R$ " . $produtos[$i->produto_id]->valor . "</td>" .
          "<td>" . $i->quantidade . "</td>" .
          "<td> R$ " .  number_format($produtos[$i->produto_id]->valor * $i->quantidade, 2, ',', '.') . "</td> </tr>" ;
        
      }
      $r = $r .
          "<tr>
          <td> Total  </td>" .
          "<td></td>" .
          "<td></td>" .
          "<td>R$ "  . number_format($total, 2, ',', '.'). "</td> </tr>" ;
      
      $r = $r . "</table>";

      return $r;

    }else{
      header('Location:/logIn.php?errormessage=Você%20não%20é%20caixa.');
    }
  }

  public static function getCompra($id)
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['caixa'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
      
      $compra = R::findOne("compras", ' id = ? ',[$id]);

      if($compra->id == 0){
        return null;
      }
      $itens = R::findAll("itens", ' compras_id = ? ',[$id]);
      $produtos = R::findAll("produtos");

      $valor = 0;

      foreach($itens as $i){
        $valor += $produtos[$i->produto_id]->valor * $i->quantidade;
      }

      $compra->valor = $valor;

      return $compra;
    }
  }

  public static function finalizar($compraId, $clienteId, $valorpago){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['caixa'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
      
      $compra = R::findOne("compras", ' id = ? ',[$compraId]);
      $compra->comprador_id = $clienteId;

      $itens = R::findAll("itens", ' compras_id = ? ',[$compraId]);
      $produtos = R::findAll("produtos");
      $valor = 0;
      foreach($itens as $i){
        $valor += $produtos[$i->produto_id]->valor * $i->quantidade;
      }
      $compra->valor = $valor;


      if($valorpago >= $compra->valor){
        $compra->valor_pago = $compra->valor;
      }else{
        $compra->valor_pago = $valorpago;
      }



      R::store($compra);

      header('Location:/caixa/index.php?message=Compra%20finalizada!');

    }
  }

  public static function comprasCliente($clienteId) {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['cliente'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
      
      $contas = R::findALL("compras", ' comprador_id = ? ', [$clienteId]);

      return $contas;

    }
  }

  public static function comprasDeventesCliente($clienteId) {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['caixa'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
      
      $contas = R::findALL("compras", ' comprador_id = ? AND valor_pago < valor ORDER BY data ASC ', [$clienteId]);

      return $contas;

    }
  }

  public static function deventes(){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['gerente'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
      
      $contas = R::findALL("compras", ' valor_pago < valor ');

      $clientes = array();

      foreach($contas as $c){
        if(isset($clientes[$c->comprador_id])){
          $clientes[$c->comprador_id] += $c->valor - $c->valor_pago;
        }
        else{
          $clientes[$c->comprador_id] = $c->valor - $c->valor_pago;
        }
      }

      $r = "<table><tr>
      <th>Nome</th>
      <th>Valor total</th>
      <th>Quitar</th>
      </tr>";
      
      foreach($clientes as $id => $valor_total){
        $cliente = R::findOne("users" , ' id = ? ', [$id])->nome;

        $r = $r .
        "<tr>
        <td>" . $cliente . "</td>
        <td>R$ " . number_format($valor_total,2,",",".") . "</td>" . 
        "<td><a href='/admin/index.php?index=61&id=" . $id . "'> <img src=\"/img/lapis.svg\" alt=\"Editar id = ". $id ."\"></a></td>" .
        "</tr>";
      }
      $r = $r . "</table>";

      return $r;

    }
  }

  public static function clientes(){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['caixa'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
      
      $clientes = R::findAll("users");

      $r = "<table><tr>
      <th>Nome</th>
      <th>Histórico</th>
      </tr>";
      
      foreach($clientes as $cliente){
        $r = $r .
        "<tr>
        <td>" . $cliente->nome . "</td>" .
        "<td><a href='/caixa/historico.php?id=" . $cliente->id . "'> <img src=\"/img/lapis.svg\" alt=\"Editar id = ". $cliente->id ."\"></a></td>" .
        "</tr>";
      }
      $r = $r . "</table>";

      return $r;

    }
  }

  public static function clientesDeventes(){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['caixa'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
      
      $contas = R::findALL("compras");

      $clientes = array();

      foreach($contas as $c){
        if(isset($clientes[$c->comprador_id])){
          $clientes[$c->comprador_id] += $c->valor - $c->valor_pago;
        }
        else{
          $clientes[$c->comprador_id] = $c->valor - $c->valor_pago;
        }
      }

      $r = "<table><tr>
      <th>Nome</th>
      <th>Dívida</th>
      <th>Quitar</th>
      </tr>";
      
      foreach($clientes as $id => $valor_total){
        $cliente = R::findOne("users" , ' id = ? ', [$id]);
        if(!isset($cliente) || $cliente->id == 0)
        {
          continue;
        }

        $r = $r .
        "<tr>
        <td>" . $cliente->nome . "</td>
        <td>R$ " . number_format($valor_total,2,",",".") . "</td>" . 
        "<td><a href='/caixa/contascliente.php?id=" . $id . "'> <img src=\"/img/lapis.svg\" alt=\"Editar id = ". $id ."\"></a></td>" .
        "</tr>";
      }
      $r = $r . "</table>";

      return $r;

    }
  }

  public static function quitar($clienteId, $valor){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['caixa'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }
      
      $contas = R::findALL("compras", ' comprador_id = ? AND valor_pago < valor ORDER BY data ASC ', [$clienteId]);



      foreach($contas as $conta){

        if($valor <= 0)
        {
          break;
        }

        $divida = $conta->valor - $conta->valor_pago;

        if($divida <= $valor){
          $conta->valor_pago += $divida;
          $valor -= $divida;
        }else{
          $conta->valor_pago += $valor;
          $valor -= $valor;
        }

        header('Location:/'. $conta->valor_pago);


        R::store($conta);

      }
    }
  }
}
