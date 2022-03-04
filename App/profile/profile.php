<?php
$data = [];
$pdo = initDb();

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

$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/CSS/profile.css">
</head>
<body>
<nav class="navigation">
    <div class="grid-container">
        <div class="grid-item1">
            <a href="/" class="tillbaka-link">← Tillbaka</a>
        </div>
        <div class="grid-item2 small-grid-container">
            <?php
            if ($_SESSION['loggedin'] === true) {
                if ($_SESSION['isAdmin'] == 1) {
                    $data["nav"] = <<<EOD
                        <div class='small-grid-item1 small-grid-item'><a href='/admin' class='profile-link'>Admin</a></div>
                        <div class='small-grid-item1 small-grid-item'><a href='/profile' class='profile-link'>$firstname $lastname</a></div>
                        <div class='small-grid-item1 small-grid-item'><a href='/logout' class='profile-link'>Logga ut</a></div>
                    EOD;

                    echo "<div class='small-grid-item1 small-grid-item'><a href='/admin' class='profile-link'>Admin</a></div>";
                    echo "<div class='small-grid-item1 small-grid-item'><a href='/profile' class='profile-link'>" . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . "</a></div>";
                    echo "<div class='small-grid-item1 small-grid-item'><a href='/logout' class='profile-link'>Logga ut</a></div>";
                } else {
                    $data["nav"] = <<<EOD
                        <div class='small-grid-item1 small-grid-item'></a></div>
                        <div class='small-grid-item1 small-grid-item'><a href='/profile' class='profile-link'>$firstname $lastname</a></div>
                        <div class='small-grid-item1 small-grid-item'><a href='/logout' class='profile-link'>Logga ut</a></div>
                    EOD;

                    echo "<div class='small-grid-item1 small-grid-item'></a></div>";
                    echo "<div class='small-grid-item1 small-grid-item'><a href='/profile' class='profile-link'>" . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . "</a></div>";
                    echo "<div class='small-grid-item1 small-grid-item'><a href='/logout' class='profile-link'>Logga ut</a></div>";
                }
            }
            ?>
        </div>
    </div>
</nav>

<section class="main-content">
    <div class="user">
        <img src="/images/user.png" alt="user" class="user-logo">
        <a href="#">Ändra Profilbild</a>
    </div>
    <div class="info-card">
        <h2 class="name"><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] ?></h2>
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
$persNr = modPersonNr($_SESSION['personNr']);
$data["firstname"] = $_SESSION['firstname'];
$data["lastname"] = $_SESSION['lastname'];
$data["username"] = $_SESSION['username'];
$data["personNr"] = $persNr;
$data["spec"] = $spec->specName;
$data["amountMeetings"] = $meetings->antal;
$data["email"] = $_SESSION['email'];

rendering("views", "profile.twig", $data);