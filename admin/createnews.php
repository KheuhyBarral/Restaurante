<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/news.class.php";

$t = $_POST["title"];
$c = $_POST["content"];

$news = new News();
$news->titulo = $t;
$news->conteudo = $c;

News::addNews($news);
header("Location: /admin/index.php?index=5&message=Notícia%20criada!");

