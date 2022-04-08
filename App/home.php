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
            <div class='small-grid-item small-grid-item1'><a href='/admin/' class='home-link'>Admin</a></div>
            <div class='small-grid-item small-grid-item2'><a href='/profile/' class='home-link'>$firstname $lastname</a></div>
            <div class='small-grid-item small-grid-item3'><a href='/logout/' class='home-link'>Logga ut</a></div>

            EOD;

        }else{
            $data["nav"] = <<<EOD
            <div class='small-grid-item small-grid-item1'></div>
            <div class='small-grid-item small-grid-item2'><a href='/profile/' class='home-link'>$firstname $lastname</a></div>
            <div class='small-grid-item small-grid-item3'><a href='/logout/' class='home-link'>Logga ut</a></div>

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
                $data["chosen"] = "<p class='patient-not-found'>Patienten finns inte i systemet</p>";

            }else {
                $patient = $_SESSION["chosen-patient"];
                $patientLastname = $patient->lastName;
                $patientFirstname = $patient->firstName;
                $patientId = $patient->patientId;
                $modPersonNr = modPersonNrDash($patient->personNr);

                $data["chosen"] = <<<EOD
                <div class="chosen-patient">
                    <div class="patient-info">
                    <img src="/images/user.png" alt="user" class="chosen-patient-img">
                        <b>$patientLastname, $patientFirstname</b>
                        <p>$modPersonNr</p>
                    </div>
                    <div class="choose-action">
                        <a href="/meeting/$patientId" class="new-meeting">Nytt Läkarbesök</a>
                        <a href="/journal/$patientId" class="read-records">Läs Journal</a>
                    </div>
                </div>
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
    $data["data"] = "";
}

$data["firstname"] = $firstname;
rendering('views', 'home.twig', $data);
