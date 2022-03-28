<?php

$filename = "C:/code/GA/database/database.db";

$dns = "sqlite:$filename";

$pdo = new PDO($dns);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->exec('PRAGMA foreign_keys = ON');

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$personNr = $_POST['personnr'];
$isAdmin = $_POST['isAdmin'];
$abbrev = $_POST['abbrev'];
$password = $_POST['password'];
$confPassword = $_POST['confpass'];
$spec = $_POST['spec'];
$email = $_POST['email'];

if ($password === $confPassword){
    $password = md5($password);
    $sql = <<<EOD
    insert into
    doctors(firstName, lastName, personNr, emailAddress, spec, nameAbbrev, password, isAdmin)
    values (?,?,?,?,?,?,?,?);
    EOD;
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstname,$lastname, $personNr, $email, $spec, $abbrev, $password, $isAdmin]);
    $_SESSION['createAttempt'] = true;
    $_SESSION['createSuccess'] = true;
    header("location: ../profile/admin.php");
}
else{
    $_SESSION['createAttempt'] = true;
    $_SESSION['createSuccess'] = false;
    header("Location: ../profile/admin.php");
}


