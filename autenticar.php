<?php

require_once("classes/util.class.php");

//echo "Console.log(" . $_GET['email'] . $_GET['senha'] . ")";


Util::autenticar($_POST['email'],$_POST['senha']);