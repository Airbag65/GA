<?php
session_start();
require_once "../../vendor/autoload.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$personNr = $_POST['personnr'];
$age = $_POST['age'];

$addPatient = <<<EOD
insert into patients(firstName, lastName, personNr, age, diagnoses) 
values
(
    ?,?,?,?,'Inga diagnoser'
);
EOD;
$stmt = $pdo->prepare($addPatient);
$stmt->execute([$firstName,$lastName,$personNr,$age]);

header("location: ../profile/admin.php");