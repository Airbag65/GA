<?php
require_once "../../vendor/autoload.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

$rawData = fopen("C:/code/GA/public/data/icd10data.txt", 'r');

while (($data = fgetcsv($rawData, 1000, " ")) !== FALSE) {
    $sql = "insert into ICD10(abbreviation, expansion) values";
    if($data[0] == "AbbreviatioExpansion") continue;
    $abbre = $data[0];
    $expan = "";

    foreach ($data as $item) {
        if ($item == $data[0]) continue;
        elseif ($item == "") continue;
        else {
            $expan .= $item;
            $expan .= " ";
        }
    }
    $sql .= "('$abbre', '$expan');";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

header("Location: ../index.php");