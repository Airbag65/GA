<?php

if (!isset($_SESSION['isAdmin'])) {
    $_SESSION['isAdmin'] = 0;
}
if (!isset($_SESSION['createAttempt'])) {
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
select meetingId, patientId, diagnosis, comment, blodtryck, puls, mattnad, date, firstName, lastName, d.doctorId
from meetings m 
join doctors d on d.doctorId = m.doctorId
where patientId is ?
order by date desc;
EOD;
$stmt = $pdo->prepare($getMeetingsSql);
$stmt->execute([$id]);
$meetings = $stmt->fetchAll();

$formerDiagnoses = [];
if (strtolower($patientData->diagnoses) === "inga diagnoser") {
    $formerDiagnoses[] = $patientData->diagnoses;
} else {
    $formerDiagnoses = explode(";", $patientData->diagnoses);
}
$data["formerDiagnoses"] = $formerDiagnoses;
$data["patientFirstName"] = $patientData->firstName;
$data["patientLastName"] = $patientData->lastName;

$modnr = modPersonNrDash($patientData->personNr);

$data["patientInfo"] = <<<patient
<div class="patient-info">
<p><b>$patientData->lastName, $patientData->firstName</b></p>
<p>Personnummer: $modnr</p>

patient;

$patientId = $patientData->patientId;
if (strtolower($patientData->bloodGroup) !== "okänd") {
    $data["patientInfo"] .= "<p>Blodgrupp: $patientData->bloodGroup</p>";
} else {
    $data["patientInfo"] .= "<a href='/save-bloodgroup/$patientId'>Lägg till blodgrupp</a>";
}
$data["patientInfo"] .= "</div>";

$data["vitals"] = <<<patient
<div class="vitals">
<p><b>Senaste Mätningar</b></p>
<p>Blodtryck: $patientData->bloodPreasure</p>
<p>Puls: $patientData->pulse</p>
<p>Blodmättnad: $patientData->spO2</p>
<p>Tidigare Diagnoser: $patientData->diagnoses</p>
</div>

patient;

$permisson = false;
foreach ($meetings as $meeting) {
    if ($meeting->doctorId == $_SESSION["id"]) {
        $permisson = true;
        break;
    }
}


foreach ($meetings as $meeting) {
    if ($permisson){
        $data["journalNote"][] = <<<eod
        <div class="grid-container-record">
            <div class="record-item">            
                <div class="small-record-item1">
                    <h3>Journalanteckning</h3><br>
                    <p>Antecknad av: $meeting->lastName, $meeting->firstName</p>
                    <p>Datum för journalanteckning: $meeting->date</p><br>
                </div>
                <div class="small-record-item2">
                    <p>Vitala parametrar vid besök:</p>
                    <p>Blodtryck: $meeting->blodtryck</p>
                    <p>Puls: $meeting->puls</p>
                    <p>Mättnad: $meeting->mattnad</p><br>
                </div>
            </div>
            <div class="record-item">
                <p>Diagnos: $meeting->diagnosis</p>
                <p class="comment">Läkarens Kommentar: $meeting->comment</p>
            </div>
        </div>
    eod;
    }
    else {
        $data["journalNote"][] = "<abbr class='no-access'>Behöringhet för att läsa saknas.</abbr>";
    }
}
rendering("views", "journal.twig", $data);
