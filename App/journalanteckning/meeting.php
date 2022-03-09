<?php

if(!isset($_SESSION['isAdmin'])){
    $_SESSION['isAdmin'] = 0;
}
if(!isset($_SESSION['createAttempt'])){
    $_SESSION['createAttempt'] = false;
}

$data = [];

$pdo = initDb();
$personellId = $_SESSION['id'];

$openIcdSql = <<<EOD
select id, expansion
from ICD10;
EOD;
$stmt = $pdo->prepare($openIcdSql);
$stmt->execute();
$ICDData = $stmt->fetchAll(PDO::FETCH_OBJ);


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

$data["personellFirstName"] = $doctor->firstName;
$data["personellLastName"] = $doctor->lastName;
$data["patientFirstName"] = $patientData->firstName;
$data["patientLastName"] = $patientData->lastName;
$data["personNumber"] = modPersonNrDash($patientData->personNr);
$data["bloodGroup"] = $patientData->bloodGroup;
$data["bloodPreasure"] = $patientData->bloodPreasure;
$data["pulse"] = $patientData->pulse;
$data["mattnad"] = $patientData->spO2;
$data["diagnoses"] = $patientData->diagnoses;
$data["id"] = $id;
$data["ICD"] = $ICDData;

rendering("views", "meeting.twig", $data);