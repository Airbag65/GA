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
require_once "../functional/functions.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

$id = $_GET['id'];
$personellId = $_SESSION['id'];

$getPatientData = <<<EOD
select *
from patients
where patientId is ?;
EOD;

$stmt = $pdo->prepare($getPatientData);
$stmt->execute([$id]);
$patientData = $stmt->fetch();

$personellSql = <<< EOD
select doctorId, firstName, lastName, emailAddress, spec, nameAbbrev
from doctors
where doctorId is ?;
EOD;
$stmt = $pdo->prepare($personellSql);
$stmt->execute([$personellId]);
$doctor = $stmt->fetch(PDO::FETCH_OBJ);

echo"Personal: ".$doctor->lastName.", ".$doctor->firstName;


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Läkarbesök</title>
</head>
<body>
<form action="../functional/saveMeeting.php">
    <label><?php echo "Patient: ".$patientData->lastName.", ".$patientData->firstName ?></label><br>
    <label><?php echo modPersonNr($patientData->personNr) ?></label><br><br>
    <label>Vitala parametrar:</label><br>
    <label><?php echo "Blodgrupp: ".$patientData->bloodGroup ?></label><br>
    <label><?php echo "Blodtryck: ".$patientData->bloodPreasure ?></label><br>
    <label><?php echo "Puls: ".$patientData->pulse ?></label><br>
    <label><?php echo "Blodmättnad: ".$patientData->spO2 ?></label><br><br>
    <label><?php echo "Tidigare diagnoser: " ?></label><br>
    <label><?php echo $patientData->diagnoses ?></label>
</form>
</body>
</html>
