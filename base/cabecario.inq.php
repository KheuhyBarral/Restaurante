<header>
    <div class="head">
        <div class="Logo">
            <a href="/index.php"><h1>La Casa Di Fugassa</h1></a>
        </div>
        <div class="menu">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <!-- <a href=""><li>Cardápio/Itens</li></a>  Será no index mesmo, o link fará ir ate ele na pagina-->
                <li><a href="/preco.php">Preços</a> </li>
                <?php 
                session_status() === PHP_SESSION_ACTIVE ?: session_start();

                if (isset($_SESSION['email'])) {
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php");

                    echo '<li><a href="/cliente/index.php">Contas</a></li>';
                    
                    if(Util::isCaixa())
                    {
                        echo '<li><a href="/caixa/index.php">Caixa</a></li>';
                    }
                    
                    
                    if(Util::isGerente())
                    {
                        echo '<li><a href="/admin/index.php">Gerenciar</a></li>';
                    }
                    echo '<li><a href="/logout.php">LogOut</a></li>' ;
                }else{
                    echo '<li><a href="/login.php">Login</a></li>';
                }
                
                ?>                  
                

            </ul>
        </div>
    </div>
    <div class="info">
        <div>
        <?php
            if (isset($_GET["errormessage"])){
                echo "<div class='error'>" . $_GET["errormessage"] ."</div>";
            }
            if (isset($_GET["message"])){
                echo "<div class='message'>" . $_GET["message"] ."</div>";
            }
            ?>
        </div>
    </div>
</header>
