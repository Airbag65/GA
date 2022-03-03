<?php
require_once "../vendor/autoload.php";
require_once "functional/functions.php";

$pdo = initDb();


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
<?php
if(!isset($_SESSION['loggedin'])){
    $_SESSION['loggedin'] = false;
}
if (isset($_SESSION['loggedin'])){
    if ($_SESSION['loggedin'] === true){
        if($_SESSION['isAdmin'] === 1){
            echo "<a href='/logout/'>Logga ut</a><br>";
            echo "<a href='/profile/'>" .$_SESSION['firstname']." ".$_SESSION['lastname']."</a><br>";
            echo "<a href='/admin/'>Admin</a>";
        }else{
            echo "<a href='/logout/'>Logga ut</a><br>";
            echo "<a href='/profile/'>" .$_SESSION['firstname']." ".$_SESSION['lastname']."</a>";
        }
        echo "<br><br>";
        $getPatientsSQL = <<<EOD
        select firstName, lastName, patientId, personNr
        from patients
        EOD;
        $stmt = $pdo->prepare($getPatientsSQL);
        $stmt->execute();
        $patients = $stmt->fetchAll();
        /*
        $patients = [];
        foreach ($getPatients as $patient) {
            $patients[] = $patient->firstName." ".$patient->lastName."  "."<a href='journalanteckning/meeting.php?id=$patient->patientId'>Nytt Läkarbesök</a>"
        ."  "." <a href='journalanteckning/journal.php?id=$patient->patientId'>Läs Journal</a><br>";
            $patients[] = $patient;
        }
        */

        echo <<<EOD
        <form action="/search" method="post">
            <label for="search-patient">Sök patient med personnummer (12 siffror):</label>
            <input type="text" id="search-patient" name="search-patient" placeholder="YYYYMMDDXXXX">
            <input type="submit">
        </form>
        EOD;
        if(isset($_SESSION["chosen-patient"])){
            if ($_SESSION['chosen-patient'] == "Patienten finns inte"){
                echo"<p>".$_SESSION["chosen-patient"]."</p>";
            }else{
                echo "<p>".$_SESSION["chosen-patient"]->lastName.", ".$_SESSION["chosen-patient"]->firstName.
                    "</p><a href='/meeting/".$_SESSION["chosen-patient"]->patientId."'>Nytt Läkarbesök</a><a href='/journal/".
                    $_SESSION["chosen-patient"]->patientId."'>Läs Journal</a>";
            }
            // om patient vald
                //Skriva ut patient
                //Länk till möte och läsa journal
        }
        var_dump($patients);


    }
    else{
        echo "<a href='/login/'>Logga in</a>";
        echo"<p>Du har inte tillgång till hemsidans funktioner när du inte är inloggad!</p>";
    }
}
?>
<br><br>
<?php
$checkForDataSql = "select * from ICD10";
$stmt = $pdo->prepare($checkForDataSql);
$stmt->execute();
$checkForData = $stmt->fetchAll();

if (empty($checkForData)){
    echo "<a href='/addData'>Lägg till ICD 10 Data</a>";
}else{
    echo "ICD 10 data finns i databasen!";
}
?>
</body>
</html>
<?php
rendering('views', 'home.twig', $data);
