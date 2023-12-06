<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isGerente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente.');
    }

?>

<div class="userEdit">
  <h2>Cadastrar Produtos</h2>
  <form action="/admin/createproduct.php" method="post">
    <ul>
        <li><label for="descricao">Descrição: </label> <input required type="text" name="descricao" id="descricao"></li> 
        <li><label for="descricao">valor: </label> <input required type="number" name="valor" id="valor" step="0.01" min="0" value="00.00"></li> 
        
        <li class="botao"><input type="submit" value="Cadastrar"></li>
    </ul>
</form> 
</div>