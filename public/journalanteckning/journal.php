<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    $_SESSION['loggedin'] = false;
}
if(!isset($_SESSION['isAdmin'])){
    $_SESSION['isAdmin'] = 0;
}
if(!isset($_SESSION['createAttempt'])){
    $_SESSION['createAttempt'] = false;
}

require_once "../../vendor/autoload.php";
require_once "../functional/functions.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

$id = intval($_GET['id']);
$personellId = intval($_SESSION['id']);

$getPatientSql = <<<EOD
select *
from patients
where patientId is ?;
EOD;
$stmt = $pdo->prepare($getPatientSql);
$stmt->execute([$id]);
$patientData = $stmt->fetch();
var_dump($patientData);


$getMeetingsSql = <<<EOD
select *
from meetings
where patientId is ?;
EOD;
$stmt = $pdo->prepare($getMeetingsSql);
$stmt->execute([$id]);
$meetings = $stmt->fetchAll();
var_dump($meetings);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Journal</title>
</head>
<body>

</body>
</html>
