<?php
require_once "../vendor/autoload.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

$rawData = file_get_contents("C:/code/GA/public/data/icd10data.txt");

var_dump($rawData);

$sql = "insert into ICD10(abbreviation, expansion) values";
$sql .= "('?', 'Hej);";
/*
while ((fgetcsv($rawData, 1000, "0x09")) !== FALSE) {
    break;
}
*/
var_dump($sql);