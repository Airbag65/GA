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
$data["patientLastName"] = $patientData->lastName;

$data["patientInfo"] = <<<patient
<div class="patient-info">
<p><b>$patientData->lastName, $patientData->firstName</b></p>
<p>Personnummer: $patientData->personNr</p>
<p>Ålder: $patientData->age</p>
patient;

$patientId = $patientData->patientId;
if(strtolower($patientData->bloodGroup) !== "okänd"){
    $data["patientInfo"] .= "<p>Blodgrupp: $patientData->bloodGroup</p>";
}else{
    $data["patientInfo"] .= "<a href='/save-bloodgroup/$patientId'>Lägg till blodgrupp</a>";
}
$data["patientInfo"] .= "</div>";

$data["vitals"] = <<<patient
<div class="vitals">
<p><b>Senaste Mätningar</b></p>
<p>Blodtryck: $patientData->bloodPreasure</p>
<p>Puls: $patientData->pulse</p>
<p>Blodmättnad: $patientData->spO2</p>
<p>Tidigare Diagnoser: </p>
</div>

patient;

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
}
rendering("views", "journal.twig", $data);
