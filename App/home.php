<?php
$pdo = initDb();

$data = [];

$sql = <<<EOD
select *
from patients;
EOD;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$patientData = $stmt->fetchAll();

if(!isset($_SESSION['loggedin'])){
    $_SESSION['loggedin'] = false;
}
$firstname = $_SESSION['firstname'] ?? null;
$lastname = $_SESSION['lastname'] ?? null;
if (isset($_SESSION['loggedin'])){
    if ($_SESSION['loggedin'] === true){
        if($_SESSION['isAdmin'] === 1){
            $data["nav"] = <<<EOD
            <div class="small-grid-item test-1"><a href="/logout/">Logga ut</a</div>
            <div class="small-grid-item test-2"><a href="/profile/">$firstname $lastname</a></div>
            <div class="small-grid-item test-3"><a href="/admin/">Admin</a></div>
            EOD;

        }else{
            $data["nav"] = <<<EOD
            <div class="small-grid-item test-2"><a href="/logout/">Logga ut</a></div>
            <div class="small-grid-item test-3"><a href="/profile/">$firstname $lastname</a></div>
            EOD;

        }
        $getPatientsSQL = <<<EOD
        select firstName, lastName, patientId, personNr
        from patients
        EOD;
        $stmt = $pdo->prepare($getPatientsSQL);
        $stmt->execute();
        $patients = $stmt->fetchAll();

        if(isset($_SESSION["chosen-patient"])){
            if ($_SESSION['chosen-patient'] == "Patienten finns inte"){
                $patient = $_SESSION["chosen-patient"];
                $data["chosen"] = "<p>Patienten finns inte i systemet</p>";

            }else {
                $patient = $_SESSION["chosen-patient"];
                $patientLastname = $patient->lastName;
                $patientFirstname = $patient->firstName;
                $patientId = $patient->patientId;

                $data["chosen"] = <<<EOD
                <p>$patientLastname, $patientFirstname</p>
                <a href="/meeting/$patientId">Nytt Läkarbesök</a>
                <a href="/journal/$patientId">Läs Journal</a>
                EOD;
            }
        }
    }
    else{
        echo "<a href='/login/'>Logga in</a>";
        echo"<p>Du har inte tillgång till hemsidans funktioner när du inte är inloggad!</p>";
    }
}
$checkForDataSql = "select * from ICD10";
$stmt = $pdo->prepare($checkForDataSql);
$stmt->execute();
$checkForData = $stmt->fetchAll();

if (empty($checkForData)){
    $data["data"] = "<a href='/addData'>Lägg till ICD 10 Data</a>";
}else{
    $data["data"] ="ICD 10 data finns i databasen!";
}
rendering('views', 'home.twig', $data);
