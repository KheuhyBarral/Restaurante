<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isGerente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente.');
    }

?>
<?php
  if(!isset($_GET["id"])){
    header('Location:/admin/index.php?errormessage=Selecione%20um%20produto.');
  }
  require_once($_SERVER["DOCUMENT_ROOT"] . "/classes/r.class.php");

  R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

  $p = R::load( 'produtos', $_GET["id"]);

  R::close();
?>

<div class="userEdit">
    <h2>Editar produto</h2>
    <form action="/admin/editproduct.php" method="post">
    <ul>
        <input type="hidden" name="id" value="<?php echo $p->id?>">
        <li><label for="descricao">Descrição: </label> <input required type="text" name="descricao" id="descricao" value="<?php echo $p->descricao?>"></li> 
        <li><label for="descricao">valor: </label> <input required type="number" name="valor" id="valor" step="0.01" min="0" value="<?php echo $p->valor?>"></li> 
        
        <li class="botao"><input type="submit" value="Editar"></li>
    </ul>
</form> 

</div>

