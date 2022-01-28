<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    $_SESSION['loggedin'] = false;
}

require_once "../vendor/autoload.php";
require_once "functional/functions.php";

$pdo = initDb();


$sql = <<<EOD
select *
from patients;
EOD;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$patientData = $stmt->fetchAll();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GA</title>
</head>
<body>
<?php
if (isset($_SESSION['loggedin'])){
    if ($_SESSION['loggedin'] === true){
        if($_SESSION['isAdmin'] === 1){
            echo "<a href='functional/sessionKill.php'>Logga ut</a><br>";
            echo "<a href='profile/profile.php'>" .$_SESSION['firstname']." ".$_SESSION['lastname']."</a><br>";
            echo "<a href='profile/admin.php'>Admin</a>";
        }else{
            echo "<a href='functional/sessionKill.php'>Logga ut</a><br>";
            echo "<a href='profile/profile.php'>" .$_SESSION['firstname']." ".$_SESSION['lastname']."</a>";
        }
        echo "<br><br>";
        $getPatientsSQL = <<<EOD
        select firstName, lastName, patientId
        from patients
        EOD;
        $stmt = $pdo->prepare($getPatientsSQL);
        $stmt->execute();
        $getPatients = $stmt->fetchAll();
        foreach ($getPatients as $patient) {
            echo $patient->firstName." ".$patient->lastName."  "."<a href='journalanteckning/meeting.php?id=$patient->patientId'>Nytt Läkarbesök</a>"
        ."  "." <a href='journalanteckning/journal.php?id=$patient->patientId'>Läs Journal</a><br>";
        }
    }
    else{
        echo "<a href='login.php'>Logga in</a>";
        echo"<p>Du har inte tillgång till hemsidans funktioner när du inte är inloggad!</p>";
    }
}
?>
<br><br>
<?php
$checkForDataSql = "select * from ICD10";
$stmt = $pdo->prepare($checkForDataSql);
$stmt->execute();
$checkForData = $stmt->fetchAll();

if (empty($checkForData)){
    echo "<a href='functional/addIcdData.php'>Lägg till ICD 10 Data</a>";
}else{
    echo "ICD 10 data finns i databasen!";
}
?>
</body>
</html>