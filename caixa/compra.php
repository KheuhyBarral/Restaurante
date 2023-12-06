<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isCaixa()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20caixa.');
    }

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Casa Di Fugassa | Restaurante IFNMG</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/cabecario.inq.php")
    ?>
    <main>
        <div class="caixa">        
            <div>
                <h2>Buscar produto</h2>
                <div>
                    <form action="compra.php" method="get">
                        <input type="hidden" name="compraid" value="<?php echo $_GET["compraid"]?>">
                        <label for="produtoid">Id:</label><input type="number" name="produtoid" id="produtoid" step="1" value="<?php echo isset($_GET["produtoid"]) ? $_GET["produtoid"] : 0?>">
                        <input type="submit" value="Buscar">
                    </form>
                </div>
                <div>
                    <?php
                        $addForm = "";
                        if(isset($_GET["produtoid"])){
                            require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/r.class.php";

                            R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
                        
                            $p = R::load("produtos", $_GET["produtoid"]);
                            
                            if($p->id == 0){
                                $r = "<h3>Produto não encontrado!</h3>";
                            }
                            else{
                                $r = 
                                "<table>
                                <tr>
                                    <th>Id</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                </tr>";
                                $r = $r .
                                    "<tr>
                                    <td>" . $p->id . "</td>" .
                                    "<td>" . $p->descricao . "</td>" .
                                    "<td>" . $p->valor . "</td> </table>";

                                if(R::load("produtos", $_GET["produtoid"])->id != 0){
                                    $addForm =  
                                    '<form action="addproduct.php" method="post">
                                        <label for="quantidade">Quantidade:</label>
                                        <input type="number" name="quantidade" id="quantidade" value="1" min="1" step="1">
                                        <input type="hidden" name="compraid" value="'. $_GET["compraid"] . '">
                                        <input type="hidden" name="id" value="'. $_GET["produtoid"] .'">
                                        <input type="submit" value="Adcionar">
                                    </form>';
                                }
                            }

                            echo $r;
                        }
                
                echo "</div>" . $addForm;
            
                ?>

            </div>



            <div>
                <h2>Itens da compra:</h2>
                <?php

                    if(isset($_GET["compraid"])){
                        require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php";
                        
                        echo Compra::listaProdutos($_GET["compraid"]);
                    }
                ?>
                <form action="finalizarcompra.php" method="get">
                    <input type="hidden" name="cliente" value="0">
                    <input type="hidden" name="compraid" value="<?php echo $_GET["compraid"]?>">
                    <input type="submit" value="Finalizar compra">
                </form>
            </div>    
        </div>    
    </main>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/rodape.inq.php")
    ?>
</body>
</html>