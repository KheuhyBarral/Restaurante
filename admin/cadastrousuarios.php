<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar user</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php   include("../base/cabecario.inq.php")    ?>
    <main>
        <fieldset>
            <legend>Criar user</legend>
            <form action="../createuser.php" method="post">
            <ul>
            <?php
                    if (isset($_GET["errormessage"])){
                        echo "<li class='error'>" . $_GET["errormessage"] ."</li>";
                    }
                    if (isset($_GET["message"])){
                        echo "<li class='message'>" . $_GET["message"] ."</li>";
                    }
                ?>
                <li><label for="email">Email: </label> <input type="text" name="email" id="email"></li>
                <li><label for="senha">Senha: </label> <input type="password" name="password" id="password"></li>
                <li><input type="submit" value="Criar"><a href="../admin"><input type="button" value="Voltar"></a></li>
            </ul>
        </form> 
        </fieldset>
    </main>
    <?php    include("../base/rodape.inq.php")    ?>
</body>
</html>