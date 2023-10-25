<h2>Login</h2>

<form action="../autenticar.php" method="post">
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
        <li><label for="senha">Senha: </label> <input type="password" name="senha" id="senha"></li>
        <li><input type="submit" value="LogIn"></li>
    </ul>

</form> 