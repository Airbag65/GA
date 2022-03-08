<?php

if(!isset($_SESSION['isAdmin'])){
    $_SESSION['isAdmin'] = 0;
}
if(!isset($_SESSION['createAttempt'])){
    $_SESSION['createAttempt'] = false;
}

$data = [];

$pdo = initDb();
$personellId = $_SESSION['id'];

$openIcdSql = <<<EOD
select id, expansion
from ICD10;
EOD;
$stmt = $pdo->prepare($openIcdSql);
$stmt->execute();
$ICDData = $stmt->fetchAll(PDO::FETCH_OBJ);


$getPatientData = <<<EOD
select *
from patients
where patientId is ?;
EOD;

$stmt = $pdo->prepare($getPatientData);
$stmt->execute([$id]);
$patientData = $stmt->fetch();

$personellSql = <<< EOD
select doctorId, firstName, lastName, emailAddress, spec, nameAbbrev
from doctors
where doctorId is ?;
EOD;
$stmt = $pdo->prepare($personellSql);
$stmt->execute([$personellId]);
$doctor = $stmt->fetch(PDO::FETCH_OBJ);

echo"Personal: ".$doctor->lastName.", ".$doctor->firstName;

$data["personellFirstName"] = $doctor->firstName;
$data["personellLastName"] = $doctor->lastName;
$data["patientFirstName"] = $patientData->firstName;
$data["patientLastName"] = $patientData->lastName;
$data["personNumber"] = modPersonNrDash($patientData->personNr);
$data["bloodGroup"] = $patientData->bloodGroup;
$data["bloodPreasure"] = $patientData->bloodPreasure;
$data["pulse"] = $patientData->pulse;
$data["mattnad"] = $patientData->spO2;
$data["diagnoses"] = $patientData->diagnoses;
$data["id"] = $id;
$data["ICDid"] = [];
$data["ICDexp"] = [];
$data["ICD"] = $ICDData;
foreach ($ICDData as $item){
    $data["ICDid"][] = $item->id;
    $data["ICDexp"][] = $item->expansion;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Läkarbesök</title>
</head>
<body>
<form action="/meeting/" method="post">
    <label><?php echo "Patient: ".$patientData->lastName.", ".$patientData->firstName ?></label><br>
    <label><?php echo modPersonNr($patientData->personNr) ?></label><br><br>
    <label>Vitala parametrar:</label><br>
    <label><?php echo "Blodgrupp: ".$patientData->bloodGroup ?></label><br>
    <label for=blodtryck""><?php echo "Föregående blodtryck: ".$patientData->bloodPreasure ?></label><br>
    <input type="text" id="blodtryck" placeholder="Ange Blodtryck" name="blodtryck"><br>
    <label for="puls"><?php echo "Föregående puls: ".$patientData->pulse ?></label><br>
    <input type="text" id="puls" placeholder="Ange Puls" name="puls"><br>
    <label for="mattnad"><?php echo "Föregående blodmättnad: ".$patientData->spO2 ?></label><br>
    <input type="text" id="mattnad" name="mattnad" placeholder="Ange Blodmättnad"><br><br>
    <label><?php echo "Tidigare diagnoser: " ?></label><br>
    <label><?php echo $patientData->diagnoses ?></label><br><br>
    <label for="diagnosis">Diagnos:</label>
    <select name="diagnosis" id="diagnosis">
        <?php
        foreach ($ICDData as $dataitem){
            echo "<option value='".$dataitem->id."'>$dataitem->expansion</option>";
        }
        ?>
    </select><br>
    <label for="comment">Kommentar:</label><br>
    <textarea name="comment" id="comment" cols="30" rows="10"></textarea><br>
    <input type="hidden" name="patientId" value="<?php echo $id?>">
    <input type="submit" value="Spara">
</form>
<br>
<a href="../../public">Tillbaka</a>
</body>
</html>

<?php
rendering("views", "meeting.twig", $data);