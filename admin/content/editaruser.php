<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isGerente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente.');
    }

?>
<?php
  if(!isset($_GET["id"])){
    header('Location:/admin/index.php?errormessage=Selecione%20um%20usuário.');
  }
  require_once($_SERVER["DOCUMENT_ROOT"] . "/classes/r.class.php");

  R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
  $u = R::load( 'users', $_GET["id"]);

  R::close();
?>
<div class="userEdit">
    <h2>Editar usuário</h2>
    <p class="alert">Deixe vazio senha ou pin para não alterar.</p>
    <form action="/admin/edituser.php" method="post">
    <ul>
        <input type="hidden" name="id" value="<?php echo $u->id?>">
        <li><label for="nome">Nome: </label> <input required type="text" name="nome" id="nome"  value="<?php echo $u->nome?>"></li>
        <li><label for="email">Email: </label> <input required type="text" name="email" id="email" value="<?php echo $u->email?>"></li>
        <li><label for="senha">Senha: </label> <input type="password" name="password" id="password"></li>
        <li><label for="cpf">CPF: </label> <input required type="text" name="cpf" id="cpf" maxlength="11" minlength="11" value="<?php echo $u->cpf?>"></li>
        <li><label for="descricao">Descrição: </label> <input required type="textarea" name="descricao" id="descricao" value="<?php echo $u->descricao?>"></li> 
        <li><label for="carteira">Carteira: </label>
                    <select id="carteira" name="carteira" required>
                        <option value="1" selected>Sim</option>
                        <option value="0" <?php if(!$u->carteira) echo "selected"?>>Não</option>
                    </select> 
        </li>
        <li><label for="pin">PIN(4 dígitos): </label> <input type="password" name="pin" id="pin" maxlength="4" minlength="4"></li>
        
            <?php 
            if(Util::isAdmin()){
                $caixa = '<option value="2"';
                if($u->isCaixa)
                $caixa .= "selected";
                $caixa .= '>Caixa</option>';

                $gerente = '<option value="3"';
                if($u->isGerente)
                $gerente .= "selected";
                $gerente .= '>Gerente</option>';

                $admin = '<option value="4"';
                if($u->isAdmin)
                $admin .= "selected";
                $admin .= '>Admin</option>';


                echo (
                '<li>
                    <label for="cargo">Cargo: </label> 
                    <select id="cargo" name="cargo" required>
                        <option value="1">Cliente</option>'
                        
                        . $caixa . $gerente . $admin .
                        
                    '</select> 
                </li>'
            );
            }else{
                echo '<input type="hidden" name="cargo" value="1">';
            }
            ?>
        
        <li class="botao"><input type="submit" value="Editar"></li>
    </ul>
</form> 

</div>
