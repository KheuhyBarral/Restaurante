<?php
require_once("classes/r.class.php");

R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

$u = R::dispense("users");
$u->nome = "DdEeV oooooooo oooooooo oooooooo ooooooooooo oooooooooooooo";
$u->email = "aaa";
$u->password = md5("1" . '__');

$u->isAdmin = true;
$u->isGerente = true;
$u->isCaixa = true;

$u->cpf = "012345678910";
$u->descricao = "Curso tec infomática turma 2021 anda de moto e carro e nao corre é gente fina de mais texto grande .php";
$u->auxilio = true;
$u->pin = "0123";

R::store($u);

R::close();

header('Location:../index.php');
