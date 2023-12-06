<?php

class News{
  public $titulo;
  public $conteudo;

  public static function addNews($news){
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    if ($_SESSION['gerente'] == true) {
      require_once("r.class.php");

      if (!R::testConnection()) {
        R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
      }

      $n = R::dispense("news");

      $n->autor = $_SESSION["nome"];
      $n->titulo = $news->titulo;
      $n->conteudo = $news->conteudo;

      date_default_timezone_set('America/Sao_Paulo');
      $n->data = date('d/m/Y H:i:s');

      R::store($n);
			R::close();

    }
  }
  public static function newsList(){
    require_once("r.class.php");

    if (!R::testConnection()) {
      R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
    }

    $news = R::findAll("news", "ORDER BY data DESC LIMIT 4");

    $r = "";
    foreach ($news as $n) {
			$r .=  "<div class='news'>"
			. "<h2>" . $n->titulo . "</h2>"
			. "<div>"
      . $n->conteudo
			. "</div>"
			. "<em>Criado por " . $n->autor . " em " . $n->data . "</em>"
			. "</div>";
		}
    return $r;
  }

  public static function allNewsList(){
    require_once("r.class.php");

    if (!R::testConnection()) {
      R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');
    }

    $news = R::findAll("news", "ORDER BY data DESC");

    $r = "";
    foreach ($news as $n) {
			$r .=  "<div class='news'>"
			. "<h2>" . $n->titulo . "</h2>"
			. "<div>"
      . $n->conteudo
			. "</div>"
			. "<em>Criado por " . $n->autor . " em " . $n->data . "</em>"
			. "</div>";
		}
    return $r;
  }
}