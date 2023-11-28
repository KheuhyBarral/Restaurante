<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";

    if(!Util::isGerente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente.');
    }


    Util::editar($_POST["id"], $_POST["nome"], $_POST["email"], $_POST["password"], $_POST["cpf"], $_POST["descricao"],$_POST["auxilio"] ,$_POST["pin"], $_POST["cargo"]);