<?php
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
    <div class="login-container">
        <form action="auth.php" method="post">
            <label for="">
                <span>Användarnamn</span>
                <br>
                <input type="text" id="userName" name="userName" class="input-field" required>
                <br><br>
                <span>Lösenord</span>
                <br>
                <input type="password" id="passWord" name="passWord" class="input-field" required>
                <br><br>
                <br>
                <input type="submit" value="Logga in" class="login-button">
            </label>
        </form>
    </div>
    <?php
    if(isset($_SESSION['loggedin'])){
        if(isset($_SESSION['loginatempt'])){
<<<<<<< HEAD
            if ($_SESSION['loginatempt']){
                if (!$_SESSION['loggedin']) {
                    echo "Fel användarnamn eller lösenord";
=======
            if ($_SESSION['loggedin']){
                echo "Välkommen ".$_SESSION['firstname']."!";
            }
            else{
                if ($_SESSION['loginatempt']) {
                    echo "<p class='invalid-login'>Fel användarnamn eller lösenord</p>";
>>>>>>> d1a3a29405843908dbaba39d28bde2e60f73a86e
                }
            }
        }
    }
    ?>
</body>
</html>
