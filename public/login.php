<?php
session_start();
require_once "../vendor/autoload.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="login.css">
    <title>Logga in</title>
</head>
<body>
    <form action="auth.php" method="post">
        <label for="">
            <span>Användarnamn</span>
            <br>
            <input type="text" id="userName" name="userName" required>
            <br>
            <span>Lösenord</span>
            <br>
            <input type="password" id="passWord" name="passWord" required>
            <br>
            <br>
            <input type="submit" value="Logga in">
        </label>
    </form>
    <?php
    if(isset($_SESSION['loggedin'])){
        if ($_SESSION['loggedin']){
            echo "Välkommen ".$_SESSION['firstname']."!";
        }
    }

    ?>
</body>
</html>
