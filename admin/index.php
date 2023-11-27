<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isGerente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente.');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
                <a href="/admin/index.php?index=1"><li>Cadastro de usuários</li></a>
                <li class="linha"></li>
                <a href="/admin/index.php?index=2"><li>Lista de usuários</li></a>
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
                        echo Util::tabelaUsuarios();
                        break;
                    case 21:
                        include("content/editaruser.php");
                        break;
                }
            }
            
            ?>
        </div>
    </main>
    <?php
    include("../base/rodape.inq.php")
    ?>
</body>
</html>