<?php

$pdo = initDb();

$data = [];

$getNameSQL = <<<EOD
select firstName, lastName, bloodGroup
from patients
where patientId is ?;
EOD;
$stmt = $pdo->prepare($getNameSQL);
$stmt->execute([$id]);
$name = $stmt->fetch();

$data["firstName"] = $name->firstName;
$data["lastName"] = $name->lastName;

$data["hiddenData"] = "<input type='hidden' name='id' value='$id'>";
rendering("views", "editBloodGroup.twig", $data);
