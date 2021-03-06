<?php
$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$personNr = $_POST['personnr'];

$addPatient = <<<EOD
insert into patients(firstName, lastName, personNr, diagnoses) 
values
(
    ?,?,?,'Inga diagnoser'
);
EOD;
$stmt = $pdo->prepare($addPatient);
$stmt->execute([$firstName,$lastName,$personNr]);

header("Location: ../profile/admin.php");