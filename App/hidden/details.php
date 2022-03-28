<?php

$apisList = [
    "doctors",
    "meetings",
    "patients",
    "ICD10"
];

$index = $id - 1;

$jsonData = file_get_contents("../App/hidden/".$apisList[$index].".json");
echo($jsonData);