<?php
require_once "../../vendor/autoload.php";
require_once "../functional/functions.php";

requireLogin();

if(!isset($_SESSION['isAdmin'])){
    $_SESSION['isAdmin'] = 0;
}
if(!isset($_SESSION['createAttempt'])){
    $_SESSION['createAttempt'] = false;
}


$pdo = initDb();

$id = intval($_GET['id']);
$personellId = intval($_SESSION['id']);

$getPatientSql = <<<EOD
select *
from patients
where patientId is ?;
EOD;
$stmt = $pdo->prepare($getPatientSql);
$stmt->execute([$id]);
$patientData = $stmt->fetch();


$getMeetingsSql = <<<EOD
select meetingId, patientId, diagnosis, comment, blodtryck, puls, mattnad, date, firstName, lastName
from meetings m 
join doctors d on d.doctorId = m.doctorId
where patientId is ?;
EOD;
$stmt = $pdo->prepare($getMeetingsSql);
$stmt->execute([$id]);
$meetings = $stmt->fetchAll();

$formerDiagnoses = [];
if(strtolower($patientData->diagnoses) === "inga diagnoser"){
    $formerDiagnoses[] = $patientData->diagnoses;
}else{
    $formerDiagnoses = explode(";", $patientData->diagnoses);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Journal | <?php echo $patientData->firstName." ".$patientData->lastName ?></title>
</head>
<body>
<?php

echo <<<patient
<p>$patientData->firstName, $patientData->lastName</p>
<p>Personnummer: $patientData->personNr</p>
<p>Ålder: $patientData->age</p>
patient;
if(strtolower($patientData->bloodGroup) !== "okänd"){
    echo "<p>Blodgrupp: $patientData->bloodGroup</p><br>";
}else{
    echo "<a href='../edit/editBloodGroup.php?id=".$patientData->patientId."'>Lägg till blodgrupp</a><br>";
}
echo <<<patient
<p>Senaste Mätningar:</p>
<p>Blodtryck: $patientData->bloodPreasure</p>
<p>Puls: $patientData->pulse</p>
<p>Blodmättnad: $patientData->spO2</p>
<p>Tidigare Diagnoser: </p><br>
patient;
foreach ($formerDiagnoses as $formerDiagnosis) {
    echo "<p>$formerDiagnosis</p>";
}
echo "<br>";
foreach ($meetings as $meeting){
    echo <<<eod
    <div class='journal-anteckning'>
        <h4>Journalanteckning</h4>
        <p>Personal: $meeting->lastName, $meeting->firstName</p>
        <p>Datum för journalanteckning: $meeting->date</p><br>
        <p>Vitala parametrar vid besök:</p>
        <p>Blodtryck: $meeting->blodtryck</p>
        <p>Puls: $meeting->puls</p>
        <p>Mättnad: $meeting->mattnad</p><br>
        <p>Diagnos: $meeting->diagnosis</p>
        <p>Läkarens Kommentar: $meeting->comment</p>
    </div>
    eod;
}
?>
<br>
<a href="../../public">Tillbaka</a>
</body>
</html>
