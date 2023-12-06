<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isGerente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente.');
    }

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
    include("../base/cabecario.inq.php")
    ?>
    <main class="admin">
        <div style="border-left:solid"></div>
        <div class="adminMenu">
            <h2>Menu</h2>
            <ul>
                <li class="linha"></li>
                <a href="/admin/index.php?index=1"><li>Cadastro de usuários / Clientes</li></a>
                <li class="linha"></li>
                <a href="/admin/index.php?index=2"><li>Lista de usuários</li></a>
                <li class="linha"></li>
                <a href="/admin/index.php?index=3"><li>Cadastro de produtos</li></a>
                <li class="linha"></li>
                <a href="/admin/index.php?index=4"><li>Lista de produtos</li></a>
                <li class="linha"></li>
                <a href="/admin/index.php?index=5"><li>Criar noticias</li></a>
                <li class="linha"></li>
                <a href="/admin/index.php?index=6"><li>Clientes com dívidas</li></a>
                <li class="linha"></li>
            </ul>

        </div>
        <div style="border-left:solid"></div>
        <div class="adminContent">
            <?php 
            if(isset($_GET["index"])){
                switch($_GET["index"]){
                    case 1:
                        include("content/cadastrousuarios.php");
                        break;
                    case 2:
                        require_once($_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php");
                        echo "<div><h2>Lista de usuários</h2>";
                        echo Util::tabelaUsuarios();
                        echo "</div>";
                        break;
                    case 21:
                        include("content/editaruser.php");
                        break;
                    case 3:
                        include("content/cadastroprodutos.php");
                        break;
                    case 4:
                        require_once($_SERVER["DOCUMENT_ROOT"] . "/classes/produto.class.php");
                        echo "<div><h2>Lista de produtos</h2>";
                        echo Produto::tabelaProdutos();
                        echo "</div>";
                        break;
                    case 41:
                        include("content/editarproduto.php");
                        break;
                    case 5:
                        include("content/cadastronoticias.php");
                        break;
                    case 6:
                        require_once($_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php");
                        echo "<div><h2>Clientes deventes</h2>";

                        echo Compra::deventes();

                        break;
                    case 61:
                        include("content/quitarcontas.php");
                        break;

                }
            }
            
            ?>
        </div>
        
    </main>
    <?php
    include("../base/rodape.inq.php");
    ?>
</body>
</html>