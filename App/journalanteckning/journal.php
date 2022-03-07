<?php

if(!isset($_SESSION['isAdmin'])){
    $_SESSION['isAdmin'] = 0;
}
if(!isset($_SESSION['createAttempt'])){
    $_SESSION['createAttempt'] = false;
}

$data = [];

$pdo = initDb();

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
$data["formerDiagnoses"] = $formerDiagnoses;
$data["patientFirstName"] = $patientData->firstName;
$data["patientLastName"] = $patientData->lastName
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

$data["patientInfo"] = <<<patient
<p>$patientData->firstName, $patientData->lastName</p>
<p>Personnummer: $patientData->personNr</p>
<p>Ålder: $patientData->age</p>
patient;
/*
echo <<<patient
<p>$patientData->firstName, $patientData->lastName</p>
<p>Personnummer: $patientData->personNr</p>
<p>Ålder: $patientData->age</p>
patient;*/
$patientId = $patientData->patientId;
if(strtolower($patientData->bloodGroup) !== "okänd"){
    $data["bloodGroup"] = "<p>Blodgrupp: $patientData->bloodGroup</p><br>";
    //echo "<p>Blodgrupp: $patientData->bloodGroup</p><br>";
}else{
    $data["bloodGroup"] = "<a href='/save-bloodgroup/$patientId'>Lägg till blodgrupp</a><br>";
    //echo "<a href='/save-bloodgroup/$patientId>Lägg till blodgrupp</a><br>";
}
$data["vitals"] = <<<patient
<p>Senaste Mätningar:</p>
<p>Blodtryck: $patientData->bloodPreasure</p>
<p>Puls: $patientData->pulse</p>
<p>Blodmättnad: $patientData->spO2</p>
<p>Tidigare Diagnoser: </p><br>
patient;
/*
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
*/
echo "<br>";
foreach ($meetings as $meeting){
    $data["journalNote"][] = <<<eod
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
    /*
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
    */
}
?>
<!--
<br>
<a href="/">Tillbaka</a>
</body>
</html>
-->
<?php
rendering("views", "journal.twig", $data);
