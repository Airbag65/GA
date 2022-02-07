<?php

$pdo = initDb();

$getNameSQL = <<<EOD
select firstName, lastName, bloodGroup
from patients
where patientId is ?;
EOD;
$stmt = $pdo->prepare($getNameSQL);
$stmt->execute([$id]);
$name = $stmt->fetch();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ändra Blodgrupp | <?php echo $name->firstName." ".$name->lastName?> </title>
</head>
<body>
<h2><?php echo "Patient: ".$name->lastName.", ".$name->firstName ?></h2>
<form action="/save-bloodgroup" method="post">
    <label for="blodgrupp">Ange blodgrupp:</label><br>
    <select name="blodgrupp" id="blodgrupp">
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="0+">0+</option>
        <option value="0-">0-</option>
    </select>
    <?php
    echo "<input type='hidden' name='id' value='".$id."'>";
    ?>
    <input type="submit" value="Spara">
</form>
</body>
</html>
