<?php
session_start();

require_once "functional/twigFunctions.php";
require_once "../vendor/autoload.php";

if (!isset($_SESSION['loginatempt'])){
    $_SESSION['loginatempt'] = false;
}

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

if(isset($_SESSION['loggedin'])){
    if(isset($_SESSION['loginatempt'])){
        if ($_SESSION['loginatempt']){
            if (!$_SESSION['loggedin']) {
                $data['loginfail'] = "Fel användarnamn eller lösenord";
            }else{
                $data['loginfail'] = "";
            }
        }
    }
}

rendering('views', 'login.twig', $data);