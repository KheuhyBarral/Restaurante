<?php

class Util
{
  public static function isLogado()
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    return isset($_SESSION['email']);
  }

  public static function isAdmin()
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    return isset($_SESSION['admin']) && $_SESSION['admin'] == true;
  }
  public static function autenticar($e, $p)
  {
    require_once "/r.class.php";

    R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');


    $u = R::findOne('users', ' email = ? AND password = ? ', [$e, md5($p . '__')]);


    if (isset($u)) {
      session_start();
      $_SESSION['email'] = $u['email'];
      $_SESSION['admin'] = $u['admin'];


      if ($_SESSION['admin']) {
        header('Location:../admin/index.php');
      } else {

        header('Location:../user/index.php');
      }
    } else {
      header('Location:index.php?message=Email%20ou%20Senha%20inválidos!');
    }
  }

  public static function criar($e, $p)
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['admin'] == true) {
      require_once("/r.class.php");


      R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

      $u = R::dispense("users");
      $u->email = $e;
      $u->password = md5($p . '__');
      $u->admin = false;

      R::store($u);

      header('Location:../admin/cadastrousuarios.php?message=Usuario%20criado!');
    } else {

      header('Location:index.php?errormessage=Você%20não%20é%20admin.');
    }
  }
  public static function delete($id){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    if ($_SESSION['admin'] != 1) {
      header('Location:index.php?errormessage=Você%20não%20é%20admin.');
    }
    require_once("/r.class.php");

    R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

    R::trash('users', $id);
  }

  public static function tabelaAdmin()
  {
    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    if ($_SESSION['admin'] != 1) {
      header('Location:index.php?errormessage=Você%20não%20é%20admin.');
    }
    require_once("/r.class.php");

    R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

    $users = R::findAll("users");

    $r = "<table><tr>
                <th>Id</th>
                <th>Email</th>
                <th>Apagar</th>
            </tr>";
    foreach ($users as $u) {
      $r = $r .
        "<tr>
        <td>" . $u->id . "</td>
        <td>" . $u->email . "</td>
        <td><a href='../admin/excluir.php?id=" . $u->id . "'> <img src=\"../img/lixeira.png\" alt=\"Deletar usuário id = ". $u->id ."\"></a></td>

    </tr>";
    }

    $r = $r . "</table>";
    return $r;
  }
}