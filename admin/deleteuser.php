<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";

if(!Util::isGerente()){
    header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente.');
}


Util::delete($_GET["id"]);