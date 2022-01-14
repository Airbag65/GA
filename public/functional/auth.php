<?php
session_start();
require_once "../../vendor/autoload.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

$username = $_POST['userName'];
$password = md5($_POST['passWord']);
var_dump($username);
var_dump($password);

$userInformationSQL = <<<EOD
select * 
from doctors
where nameAbreiv is ?;
EOD;
$stmt = $pdo->prepare($userInformationSQL);
$stmt->execute([$username]);
$userInformation = $stmt->fetch();

$_SESSION['loggedin'] = false;

if($password === $userInformation->password){
    $_SESSION['username'] = $userInformation->nameAbreiv;
    $_SESSION['password'] = $userInformation->password;
    $_SESSION['email'] = $userInformation->emailAddress;
    $_SESSION['spec'] = $userInformation->spec;
    $_SESSION['firstname'] = $userInformation->firstName;
    $_SESSION['lastname'] = $userInformation->lastName;
    $_SESSION['id'] = $userInformation->doctorId;
    $_SESSION['loggedin'] = true;
    $_SESSION['loginatempt'] = true;
    var_dump("Logged In");
    header("location: ../index.php");
}else{
    $_SESSION['loginatempt'] = true;
    header("location: ../login.php");
}
