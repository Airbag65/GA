<?php
var_dump($_POST);

$settingId = $_POST["settingId"];
$personellId = $_POST["personellId"];
$patientId = $_POST["patientId"];


$pdo = initDb();

$updateSQL = <<<EOD
update doctors
set viewSetting = ?
where doctorId is ?;
EOD;
$stmt = $pdo->prepare($updateSQL);
$stmt->execute([$settingId, $personellId]);

$_SESSION["setting"] = $settingId;

redirectURL("/journal/$patientId");