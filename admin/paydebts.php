<?php
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    
    if($_SESSION['gerente'] != 1){
      header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente!');
    }
    else{
      require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php";


      Compra::quitar($_POST["cliente"], $_POST["valor"]);

      header('Location:/admin/index.php?message=Valor%20quitado!&index=61&id=' . $_POST["cliente"]);
    }
