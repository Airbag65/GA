<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    $_SESSION['loggedin'] = false;
}
if(!isset($_SESSION['isAdmin'])){
    $_SESSION['isAdmin'] = 0;
}
if(!isset($_SESSION['createAttempt'])){
    $_SESSION['createAttempt'] = false;
}

require_once "../../vendor/autoload.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

if($_SESSION['isAdmin'] === 0){
    echo"<script>alert('Du har inte Admin behörighet')</script>";
    header('location: ../');
}
elseif($_SESSION['isAdmin'] === 1){
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../../public/CSS/admin.css" >
        <title>Administrering</title>
    </head>
    <body>
    <a href="../../public" class="go-back"> <-- Tillbaka till start </a>
    <div class="add-container">
        <div class="add-patient">
            <h2>Lägg till patient</h2>
            <form action="../functional/savePatient.php" method="post">
                <input name="firstname" type="text" placeholder="Förnamn"><br><br>
                <input name="lastname" type="text" placeholder="Efternamn"><br><br>
                <input name="personnr" type="text" placeholder="YYYYMMDDXXXX"><br><br>
                <input name="age" type="number" placeholder="Ålder"><br><br>
                <input type="submit" value="Lägg till">
            </form>
        </div>
        <div class="add-personell">
            <h2>Lägg till Personal</h2>
            <form action="../functional/savePersonell.php" method="post">
                <input type="text" placeholder="Förnamn" name="firstname"><br><br>
                <input type="text" placeholder="Efternamn" name="lastname"><br><br>
                <input type="number" name="spec" placeholder="Specialisering"><br><br>
                <input type="text" name="email" placeholder="E-mail"><br><br>
                <input type="text" placeholder="YYYYMMDDXXXX" name="personnr"><br><br>
                <input type="number" name="age" placeholder="Ålder"><br><br>
                <input type="number" name="isAdmin" placeholder="Admin?"><br><br>
                <input type="text" name="abbrev" placeholder="Namnförkortning/Användarnamn"><br><br>
                <input type="password" name="password" placeholder="Lösenord"><br><br>
                <input type="password" name="confpass" placeholder="Upprepa lösenord"><br><br>
                <input type="submit" value="Lägg till">
            </form>
            <?php
            if($_SESSION['createAttempt']){
                if($_SESSION['createSuccess']) {
                    echo "<p>Personalen har lagts till!</p>";
                } else {
                    echo "<p>Lösenorden matchar inte!<br>Försök igen!</p>";
                }
            }
            ?>
        </div>
    </div>
    </body>
    </html>
<?php
}