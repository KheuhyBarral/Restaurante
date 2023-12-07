<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isGerente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente.');
    }

?>
<div class="userEdit">
    <h2>Criar usuário</h2>
    <form action="/admin/createuser.php" method="post">
    <ul>
        <li><label for="nome">Nome: </label> <input type="text" name="nome" id="nome"></li>
        <li><label for="email">Email: </label> <input type="text" name="email" id="email"></li>
        <li><label for="senha">Senha: </label> <input type="password" name="password" id="password"></li>
        <li><label for="cpf">CPF: </label> <input type="text" name="cpf" id="cpf" maxlength="11" minlength="11"></li>
        <li><label for="descricao">Descrição: </label> <input type="text" name="descricao" id="descricao"></li> 
        <li><label for="carteira">Carteira: </label>
                    <select id="carteira" name="carteira" required>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select> 
        </li>
        <li><label for="pin">PIN(4 dígitos): </label> <input type="password" name="pin" id="pin" maxlength="4" minlength="4"></li>

        <?php 
            if(Util::isAdmin()){
                echo(
                    '<li>
                        <label for="cargo">Cargo: </label> 
                        <select id="cargo" name="cargo">
                            <option value="1">Cliente</option>
                            <option value="2">Caixa</option>
                            <option value="3">Gerente</option>
                            <option value="4">Admin</option>
                        </select>
                    </li>'
                );
            }else{
                echo '<input type="hidden" name="cargo" value="1">';
            }
        ?>

        <li><input type="submit" value="Criar"></li>
    </ul>
</form> 
</div>

