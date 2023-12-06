<?php
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    
    if($_SESSION['caixa'] != 1){
      header('Location:/logIn.php?errormessage=Você%20não%20é%20caixa!');
    }
    else{
      require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php";


      Compra::addProduto($_POST["compraid"], $_POST["id"], $_POST["quantidade"]);
    }



