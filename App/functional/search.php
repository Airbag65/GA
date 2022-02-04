<?php

$pdo = initDb();

var_dump($_POST['search-patient']);

$personNr = intval($_POST['search-patient']);

$fetchPatientSql = <<<EOD
select *
from patients
where personNr is ?
EOD;
$stmt = $pdo->prepare($fetchPatientSql);
$stmt->execute([$personNr]);
$fetchPatient = $stmt->fetch();

if($fetchPatient){
    $_SESSION['chosen-patient'] = $fetchPatient;
    var_dump($_SESSION['chosen-patient']);
}else{
    $_SESSION['chosen-patient'] = "Patienten finns inte";
}

header("Location: /home");
