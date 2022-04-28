<?php

if(!isset($_SESSION['isAdmin'])){
    $_SESSION['isAdmin'] = 0;
}
if(!isset($_SESSION['createAttempt'])){
    $_SESSION['createAttempt'] = false;
}

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);

$pdo = initDb();

$personellId = $_SESSION['id'];

$pureDiag = $purifier->purify($_POST["diagnosis"]);
$pureId = $purifier->purify($_POST["patientId"]);
$pureBloodpreasure = $purifier->purify($_POST["blodtryck"]);
$purePulse = $purifier->purify($_POST["puls"]);
$pureMattnad = $purifier->purify($_POST["mattnad"]);
$pureComment = $purifier->purify($_POST["comment"]);

$getICDsql = <<<EOD
select *
from ICD10
where id is ?;
EOD;
$stmt = $pdo->prepare($getICDsql);
$stmt->execute([$pureDiag]);
$ICD = $stmt->fetch();
var_dump($ICD);

$getPatientsql = <<<EOD
select *
from patients
where patientId is ?
EOD;
$stmt = $pdo->prepare($getPatientsql);
$stmt->execute([$pureId]);
$patientData = $stmt->fetch();

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
    $stmt->execute([$ICD->abbreviation, $pureBloodpreasure, $purePulse, $pureMattnad, $pureId]);
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
    $stmt->execute([$patientData->diagnoses, $pureBloodpreasure, $purePulse, $pureMattnad, $pureId]);
}

$updateBlodtryck = <<<EOD
insert into blodtryck(blodtryck, patientId) 
values (?, ?);
EOD;
$stmt = $pdo->prepare($updateBlodtryck);
$stmt->execute([$pureBloodpreasure, $pureId]);

$updatePuls = <<<EOD
insert into puls(puls, patientId) 
values (?, ?);
EOD;
$stmt = $pdo->prepare($updatePuls);
$stmt->execute([$purePulse, $pureId]);

$updateMattnad = <<<EOD
insert into syresättning(syresattning, patientId) 
values (?, ?);
EOD;
$stmt = $pdo->prepare($updateMattnad);
$stmt->execute([$pureMattnad, $pureId]);

$saveMeetingSql = <<<EOD
insert into meetings(doctorId, patientId, diagnosis, comment, blodtryck, puls, mattnad)
values (?,?,?,?,?,?,?);
EOD;
$stmt = $pdo->prepare($saveMeetingSql);
$stmt->execute([$personellId, $pureId, $ICD->abbreviation, $pureComment, $pureBloodpreasure, $purePulse, $pureMattnad]);
header("Location: /journal/".$pureId);