<?php
require_once "functional/twigFunctions.php";
require "../vendor/autoload.php";

session_start();
if (!isset($_SESSION['loginatempt'])){
    $_SESSION['loginatempt'] = false;
}

require_once "../vendor/autoload.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

$data = [
    "userField" => "Användarnamn eller mejl",
    "passwordField" => "Lösenord"
];


rendering('views', 'login.twig', $data);

