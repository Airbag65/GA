<?php

if(!isset($_SESSION['isAdmin'])){
    $_SESSION['isAdmin'] = 0;
}
if(!isset($_SESSION['createAttempt'])){
    $_SESSION['createAttempt'] = false;
}

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

$personellId = $_SESSION['id'];

var_dump($_POST);

$getICDsql = <<<EOD
select *
from ICD10
where id is ?;
EOD;
$stmt = $pdo->prepare($getICDsql);
$stmt->execute([$_POST['diagnosis']]);
$ICD = $stmt->fetch();
var_dump($ICD);

$getPatientsql = <<<EOD
select *
from patients
where patientId is ?
EOD;
$stmt = $pdo->prepare($getPatientsql);
$stmt->execute([$_POST['patientId']]);
$patientData = $stmt->fetch();
var_dump($patientData);

if (strtolower($patientData->diagnoses) === "inga diagnoser"){
    $updateDiagnosesSql = <<<EOD
    update patients
    set diagnoses = ?,
        bloodPreasure = ?,
        pulse = ?,
        spO2 = ?
    where patientId is ?;
    EOD;
    $stmt = $pdo->prepare($updateDiagnosesSql);
    $stmt->execute([$ICD->abbreviation, $_POST['blodtryck'], $_POST['puls'], $_POST['mattnad'], $_POST['patientId']]);
} else{
    $patientData->diagnoses .= ";".$ICD->abbreviation;
    $updateDiagnosesSql = <<<EOD
    update patients
    set diagnoses = ?,
        bloodPreasure = ?,
        pulse = ?,
        spO2 = ?
    where patientId is ?;
    EOD;
    $stmt = $pdo->prepare($updateDiagnosesSql);
    $stmt->execute([$patientData->diagnoses, $_POST['blodtryck'], $_POST['puls'], $_POST['mattnad'], $_POST['patientId']]);
}

$updateBlodtryck = <<<EOD
insert into blodtryck(blodtryck, patientId) 
values (?, ?);
EOD;
$stmt = $pdo->prepare($updateBlodtryck);
$stmt->execute([$_POST['blodtryck'], $_POST['patientId']]);

$updatePuls = <<<EOD
insert into puls(puls, patientId) 
values (?, ?);
EOD;
$stmt = $pdo->prepare($updatePuls);
$stmt->execute([$_POST['puls'], $_POST['patientId']]);

$updateMattnad = <<<EOD
insert into syresättning(syresattning, patientId) 
values (?, ?);
EOD;
$stmt = $pdo->prepare($updateMattnad);
$stmt->execute([$_POST['mattnad'], $_POST['patientId']]);

$saveMeetingSql = <<<EOD
insert into meetings(doctorId, patientId, diagnosis, comment, blodtryck, puls, mattnad)
values (?,?,?,?,?,?,?);
EOD;
$stmt = $pdo->prepare($saveMeetingSql);
$stmt->execute([$_SESSION['id'], $_POST['patientId'], $ICD->abbreviation, $_POST['comment'], $_POST['blodtryck'], $_POST['puls'], $_POST['mattnad']]);
//header('Location: /');