<?php
require_once "../../vendor/autoload.php";

$filename = "/home/anton/Desktop/GA/src/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');


$sql = <<<EOD
insert into patients(firstName, lastName, personNr, age)
values('Bengt', 'Wallgren', 20000000, 100);
EOD;
$stmt = $pdo->prepare($sql);
$stmt->execute();

$sqlu = <<<EOD
select *
from patients;
EOD;
$stmt = $pdo->prepare($sqlu);
$stmt->execute();
$data = $stmt->fetchAll();

var_dump($data)
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

</body>
</html>