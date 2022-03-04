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

if ($_SESSION['loggedin'] === true) {
    if ($_SESSION['isAdmin'] == 1) {
        $data["nav"] = <<<EOD
                        <div class='small-grid-item1 small-grid-item'><a href='/admin' class='profile-link'>Admin</a></div>
                        <div class='small-grid-item1 small-grid-item'><a href='/profile' class='profile-link'>$firstname $lastname</a></div>
                        <div class='small-grid-item1 small-grid-item'><a href='/logout' class='profile-link'>Logga ut</a></div>
                       EOD;

    } else {
        $data["nav"] = <<<EOD
                        <div class='small-grid-item1 small-grid-item'></a></div>
                        <div class='small-grid-item1 small-grid-item'><a href='/profile' class='profile-link'>$firstname $lastname</a></div>
                        <div class='small-grid-item1 small-grid-item'><a href='/logout' class='profile-link'>Logga ut</a></div>
                    EOD;

    }
}

$persNr = modPersonNr($_SESSION['personNr']);
$data["firstname"] = $_SESSION['firstname'];
$data["lastname"] = $_SESSION['lastname'];
$data["username"] = $_SESSION['username'];
$data["personNr"] = $persNr;
$data["spec"] = $spec->specName;
$data["amountMeetings"] = $meetings->antal;
$data["email"] = $_SESSION['email'];

rendering("views", "profile.twig", $data);