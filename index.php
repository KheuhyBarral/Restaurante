<?php
require_once("classes/r.class.php");

R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

if(!R::find("users", '1'))
{
    $u = R::dispense("users");
    $u->nome = "Developer nome grande para não dar errado, guisso é gente fina";
    $u->email = "admin@admin.com";
    $u->password = md5("123456" . '__');

    $u->isAdmin = true;
    $u->isGerente = true;
    $u->isCaixa = true;

    $u->cpf = "012345678910";
    $u->descricao = "Curso tec infomática turma 2021 anda de moto e carro e nao corre é gente fina de mais texto grande .php";
    $u->auxilio = true;
    $u->pin = "0123";

    

    R::store($u);

    R::close();

    header('Location:/login.php?message=Email para teste criado. Email: admin@admin.com Senha: 123456');

}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Casa Di Fugassa | Restaurante IFNMG</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    include("base/cabecario.inq.php")
    ?>
    <main>
        HOME
    </main>
    <?php
    include("base/rodape.inq.php")
    ?>
</body>
</html>