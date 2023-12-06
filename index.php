<?php
require_once("classes/r.class.php");

R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

if(!R::find("users", '1'))
{
    $u = R::dispense("users");
    $u->nome = "Developer";
    $u->email = "admin@admin.com";
    $u->password = md5("123456" . '__');

    $u->isAdmin = true;
    $u->isGerente = true;
    $u->isCaixa = true;

    $u->cpf = "012345678910";
    $u->descricao = "Curso tec infomática turma 2021 anda de moto e carro e nao corre é gente fina de mais texto grande .php";
    $u->carteira = true;
    $u->pin = "0123";

    

    R::store($u);
        
    $compra = R::dispense("compras");

    $compra->data = date('d/m/Y H:i:s');

    $compra->vendedor_id = 1;

    $compra->comprador_id = 1;

    $p = R::dispense("produtos");

    $p->descricao = "Suco de caju com açucar que veio das margens do rio araguaia";
    $p->valor = 3.59;

    $i = R::dispense("itens");

    $i->produto = $p;
    $i->quantidade = 2;

    $compra->ownItensList[] = $i;

    $compra->valor = 10000.99;
    $compra->valor_pago = 10000.99;

    R::store($compra);

    R::trash('itens', 1);
    R::trash('produtos', 1);
    R::trash('compras', 1);

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
        <h2>Notícias</h2>
        <?php
        require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/news.class.php";
        if(isset($_GET["all"]) && $_GET["all"] == 1){
            echo '<form action="index.php">
                <input type="hidden" name="all" value="0">
                <input type="submit" value="Ver menos">
            </form>';
            echo News::allNewsList();  
        }else{
            echo News::newsList();
            echo '<form action="index.php">
            <input type="hidden" name="all" value="1">
            <input type="submit" value="Ver mais">
        </form>';
        }
        ?>
        

    </main>
    <?php
    include("base/rodape.inq.php")
    ?>
</body>
</html>