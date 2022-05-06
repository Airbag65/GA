<?php
$pdo = initDb();

$rawData = fopen("C:/code/GA/database/icd10data.txt", 'r');

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

header("Location: /home");