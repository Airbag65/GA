<?php

$pdo = initDb();

$id = intval($_POST['id']);
$group = $_POST['blodgrupp'];

$setBloodGroup = <<<EOD
update patients
set bloodGroup = ?
where patientId is ?;
EOD;
$stmt = $pdo->prepare($setBloodGroup);
$stmt->execute([$group, $id]);

header("Location: /journal/".$id);