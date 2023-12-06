<?php

class Produto{
  public static function criar($descricao, $valor){

    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['gerente'] == true) {
      require_once("r.class.php");


      R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

      $p = R::dispense("produtos");

      $p->descricao = $descricao;
      $p->valor = $valor;

      R::store($p);

      R::close();    

      header('Location:/admin?index=3&message=Produto%criado!');
    }
  }
  public static function editar($id, $descricao, $valor){

    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['gerente'] == true) {
      require_once("r.class.php");


      R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

      $p = R::load("produtos", $id);

      $p->descricao = $descricao;
      $p->valor = $valor;

      R::store($p);

      R::close();    

      header('Location:/admin?index=4&message=Produto%20editado!');
    }
  }

  public static function delete($id){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['gerente'] == true) {
      require_once("r.class.php");


      R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

      R::trash("produtos", $id);

      R::Close();

      header('Location:/admin?index=3&message=Produto%deletado!');
    }
  }

  public static function tabelaProdutos()
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    if ($_SESSION['gerente'] != 1) {
      header('Location:index.php?errormessage=Você%20não%20é%20gerente.');
    }
    require_once("r.class.php");

    R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
    
    $produtos = R::findAll("produtos");
    
    R::close();
    $r = "<table><tr>
                <th>Id</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Editar</th>
                <th>Apagar</th>
            </tr>";
    foreach ($produtos as $p) {
      $r = $r .
        "<tr>
        <td>" . $p->id . "</td>" .
        "<td>" . $p->descricao . "</td>" .
        "<td>" . $p->valor . "</td>";
        
        $r = $r ."<td><a href='/admin/index.php?index=41&id=" . $p->id . "'> <img src=\"/img/lapis.svg\" alt=\"Editar id = ". $p->id ."\"></a></td>
        <td><a href='/admin/deleteproduct.php?id=" . $p->id . "'> <img src=\"/img/lixo.svg\" alt=\"Deletar protudo id = ". $p->id ."\"></a></td>
    </tr>";
    }

    $r = $r . "</table>";
    return $r;


  }
}