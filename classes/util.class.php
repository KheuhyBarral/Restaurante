<?php

class Util
{
  public static function logOut()
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    
    if (isset($_SESSION['email'])) {
      $_SESSION = array();
  
      session_destroy();
  
      header("Location: index.php");
      exit();
  } else {
      header("Location: index.php");
      exit();
  }
  }

  public static function isAdmin()
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    return isset($_SESSION['admin']) && $_SESSION['admin'] == true;
  }

  public static function isGerente()
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    return isset($_SESSION['gerente']) && $_SESSION['gerente'] == true;
  }

  public static function isCaixa()
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    return isset($_SESSION['caixa']) && $_SESSION['caixa'] == true;
  }

  public static function isCliente()
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    return isset($_SESSION['cliente']) && $_SESSION['cliente'] == true;
  }

  
  public static function autenticar($e, $p)
  {
    require_once "r.class.php";

    if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }


    $u = R::findOne('users', ' email = ? AND password = ? ', [$e, md5($p . '__')]);


    if (isset($u)) {
      session_start();
      $_SESSION['email'] = $u['email'];
      $_SESSION['id'] = $u['id'];
      $_SESSION['nome'] = $u['nome'];
      $_SESSION['admin'] = $u['isAdmin'];
      $_SESSION['gerente'] = $u['isGerente'];
      $_SESSION['caixa'] = $u['isCaixa'];
      $_SESSION['cliente'] = true;


      if ($_SESSION['admin']) {
        header('Location:/admin/index.php');
      } else {

        header('Location:/index.php');
      }
    } else {
      header('Location:login.php?errormessage=Email%20ou%20Senha%20inválidos!');
    }

    R::close();
  }

  public static function criar($nome, $e, $p, $cpf, $desc, $carteira, $pin, $cargo)
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['gerente'] == true) {
      require_once("r.class.php");


      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }

      $t = R::findOne('users', ' email = ?', [$e]);

      if(isset($t)){
        header('Location:/admin/index.php?index=1&errormessage=Este%20email%20já%20existe!');
        return;
      }


      $u = R::dispense("users");
      $u->email = $e;
      $u->password = md5($p . '__');

      $u->nome = $nome;
      $u->cpf = $cpf;
      $u->descricao = $desc;
      if($carteira == 1){
        $u->carteira = true;
      }
      else{
        $u->carteira = false;
      }
      $u->pin = md5($pin . '__');

      $u->isCaixa = false;
      $u->isGerente = false;
      $u->isAdmin = false;

      if($_SESSION['admin']){     //Evita que gerentes alterem o cargo  
        if($cargo > 1){
          $u->isCaixa = true;
        }
        if($cargo > 2){
          $u->isGerente = true;
        }
        if($cargo > 3){
          $u->isAdmin = true;
        }
      }


      R::store($u);

      R::close();

      header('Location:/admin/index.php?index=1&message=Usuario%20criado!');
    } else {

      header('Location:/admin/index.php?errormessage=Você%20não%20é%20admin.');
    }
  }

  public static function editar($id, $nome, $e, $p, $cpf, $desc, $carteira, $pin, $cargo)
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['gerente'] == true) {
      require_once("r.class.php");
      
      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }

      $u = R::load("users", $id );

      $u->email = $e;
      if($p){
        $u->password = md5($p . '__');
      }

      $u->nome = $nome;
      $u->cpf = $cpf;
      $u->descricao = $desc;
      if($carteira == 1){
        $u->carteira = true;
      }
      else{
        $u->carteira = false;
      }
      if($pin){
        $u->pin = md5($pin . '__');
      }

      if($_SESSION['admin']){     //Evita que gerentes alterem o cargo  
        if($cargo > 1){
          $u->isCaixa = true;
        }else{
          $u->isCaixa = false;
        }
        if($cargo > 2){
          $u->isGerente = true;
        }else{
          $u->isGerente = false;
        }
        if($cargo > 3){
          $u->isAdmin = true;
        }else{
          $u->isAdmin = false;
        }
      }


      R::store($u);

      R::close();

      header('Location:/admin/index.php?index=2&message=Usuario%20Editado!');
    } else {

      header('Location:/admin/index.php?errormessage=Você%20não%20é%20admin.');
    }
  }

  public static function delete($id){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    if ($_SESSION['admin'] != 1) {
      header('Location:index.php?errormessage=Você%20não%20é%20admin.');
    }
    require_once("r.class.php");

    if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }

    R::trash('users', $id);

    R::close();

    header('Location:/admin?index=2&message=Usuario%20deletado!');
  }

  public static function checkPIN($id, $pin){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    if ($_SESSION['caixa'] != 1) {
      header('Location:index.php?errormessage=Você%20não%20é%20caixa.');
    }
    require_once("r.class.php");

    if (!R::testConnection()) {
      R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
    }
    
    $u = R::findOne('users', ' id = ? AND pin = ? ', [$id, md5($pin . '__')]);

    R::close();

    if(isset($u) && $u->id != 0){
      return true;
    }
    return false;

  }

  public static function tabelaUsuarios()
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    if ($_SESSION['gerente'] != 1) {
      header('Location:index.php?errormessage=Você%20não%20é%20gerente.');
    }
    require_once("r.class.php");

    if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }

    $users = R::findAll("users");

    $r = "<table><tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Editar</th>
                <th>Apagar</th>
            </tr>";
    foreach ($users as $u) {
      $r = $r .
        "<tr>
        <td>" . $u->id . "</td>
        <td>" . $u->nome . "</td>";
        
        if($u->isAdmin){
          $r .= "<td>Admin</td>";
        }
        else if($u->isGerente){
          $r .= "<td>Gerente</td>";
        }
        else if($u->isCaixa){
          $r .= "<td>Caixa</td>";
        }
        else{
          $r .= "<td>Cliente</td>";

        }


        $r = $r ."<td><a href='/admin/index.php?index=21&id=" . $u->id . "'> <img src=\"/img/lapis.svg\" alt=\"Editar id = ". $u->id ."\"></a></td>
        <td><a href='/admin/deleteuser.php?id=" . $u->id . "'> <img src=\"/img/lixo.svg\" alt=\"Deletar usuário id = ". $u->id ."\"></a></td>
    </tr>";
    }

    $r = $r . "</table>";
    return $r;

    R::close();
  }

  public static function getClient($id)
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    
    require_once("r.class.php");

    if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }

    $c = R::findOne("users", " id = ? ", [$id]);

    if(isset($c))
    {
      return $c->nome;
    }
    return "não encontrado!";

    R::close();

  }

  public static function isCarteira($id){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    if ($_SESSION['caixa'] != 1) {
      header('Location:index.php?errormessage=Você%20não%20é%20caixa.');
    }
    require_once("r.class.php");

    if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }

    $c = R::findOne("users", " id = ? ", [$id]);

    if(isset($c))
    {
      return $c->carteira;
    }
    return false;

    R::close();
  }
}