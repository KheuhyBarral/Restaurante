<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/produto.class.php";

    if(!Util::isGerente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente.');
    }
    
    Produto::criar($_POST["descricao"], $_POST["valor"]);