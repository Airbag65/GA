<?php
require_once "../vendor/autoload.php";

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');


$sql = <<<EOD
select *
from patients;
EOD;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$patientData = $stmt->fetchAll();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GA</title>
</head>
<body>
<form action="savePatient.php" method="post">
    <label>Lägg till patient:</label><br>
    <input name="firstname" type="text" placeholder="Förnamn"><br><br>
    <input name="lastname" type="text" placeholder="Efternamn"><br><br>
    <input name="personnr" type="text" placeholder="YYYYMMDDXXXX"><br><br>
    <input name="age" type="number" placeholder="Ålder"><br><br>
    <input type="submit" value="Lägg till">
</form>
<?php
var_dump($patientData)
?>
</body>
</html>