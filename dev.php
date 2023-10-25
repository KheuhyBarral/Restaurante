<?php
require_once("/classes/r.class.php");

R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

$u = R::dispense("users");
$u->email = "1";
$u->password = md5("1" . '__');
$u->admin = true;

R::store($u);

header('Location:../index.php');