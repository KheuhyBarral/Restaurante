<?php
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    
    if($_SESSION['caixa'] != 1){
      header('Location:/logIn.php?errormessage=Você%20não%20é%20caixa!');
    }
    else{
      require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php";
      require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";

      if(!Util::checkPIN($_POST["cliente"], $_POST["pin"])){
        header('Location:/caixa/finalizarcompra.php?errormessage=PIN%20inválido!&compraid=' . $_POST["compraid"] . '&valorpago=' . $_POST["valorpago"] . '&cliente='. $_POST["cliente"]);
      }else{
        Compra::finalizar($_POST["compraid"], $_POST["cliente"], $_POST["valorpago"]);
      }
    }
