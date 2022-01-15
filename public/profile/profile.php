<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    $_SESSION['loggedin'] = false;
}
require_once "../../vendor/autoload.php";
require_once "../functional/functions.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

if(!$_SESSION['loggedin']){
    header("location: ../login.php");
}else{
    $personNr = $_SESSION['personNr'];
    $modPersonNr = modPersonNr($personNr);

$specSQL = <<<EOD
select specName
from doctors
join specialisations s on s.specId = doctors.spec
where doctorId is ?;
EOD;
$stmt = $pdo->prepare($specSQL);
$stmt->execute([$_SESSION['id']]);
$spec = $stmt->fetch();

$meetingsSQL = <<<EOD
select count(m.doctorId) as antal
from doctors
join meetings m on doctors.doctorId = m.doctorId
where doctors.doctorId is ?;
EOD;
$stmt = $pdo->prepare($meetingsSQL);
$stmt->execute([$_SESSION['id']]);
$meetings = $stmt->fetch();

?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="profile.css">
        <title>Profil - <?php echo $_SESSION['firstname']." ".$_SESSION['lastname']; ?></title>
    </head>
    <body>
        <nav class="navigation">
            <div class="grid-container">
                <div class="grid-item1">
                    <a href="../" class="tillbaka-link">← Tillbaka</a>
                </div>
                <div class="grid-item2 small-grid-container">
                    <?php
                    if ($_SESSION['loggedin'] === true){
                        if($_SESSION['isAdmin'] === 1){
                            echo "<div class='small-grid-item1 small-grid-item'><a href='admin.php' class='profile-link'>Admin</a></div>";
                            echo "<div class='small-grid-item1 small-grid-item'><a href='profile.php' class='profile-link'>" .$_SESSION['firstname']." ".$_SESSION['lastname']."</a></div>";
                            echo "<div class='small-grid-item1 small-grid-item'><a href='../functional/sessionKill.php' class='profile-link'>Logga ut</a></div>";
                        }else{
                            echo "<div class='small-grid-item1 small-grid-item'></a></div>";
                            echo "<div class='small-grid-item1 small-grid-item'><a href='profile.php' class='profile-link'>" .$_SESSION['firstname']." ".$_SESSION['lastname']."</a></div>";
                            echo "<div class='small-grid-item1 small-grid-item'><a href='../functional/sessionKill.php' class='profile-link'>Logga ut</a></div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </nav>

        <section class="main-content">
            <div class="user">
                <img src="../images/user.png" alt="user" class="user-logo">
                <a href="#">Ändra Profilbild</a>
            </div>
            <div class="info-card">
                <h2 class="name"><?php echo $_SESSION['firstname']." ".$_SESSION['lastname'] ?></h2>
                <p class="username"><?php echo $_SESSION['username'] ?></p>
                <hr>
                <p class="card-info"><?php echo $modPersonNr ?></p>
                <p class="card-info"><?php echo $spec->specName ?></p>
                <p class="card-info">Antal Besök: <?php echo $meetings->antal ?></p>
                <p class="card-info"><?php echo $_SESSION['email'] ?></p>
            </div>
        </section>
    </body>
    </html>
<?php
}