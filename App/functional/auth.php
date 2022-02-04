<?php

$pdo = initDb();

$username = $_POST['userName'];
$password = md5($_POST['passWord']);
var_dump($username);
var_dump($password);

$userInformationSQL = <<<EOD
select * 
from doctors
where nameAbbrev is ?;
EOD;
$stmt = $pdo->prepare($userInformationSQL);
$stmt->execute([$username]);
$userInformation = $stmt->fetch();

$_SESSION['loggedin'] = false;

if($password === $userInformation->password){
    $_SESSION['username'] = $userInformation->nameAbbrev;
    $_SESSION['password'] = $userInformation->password;
    $_SESSION['email'] = $userInformation->emailAddress;
    $_SESSION['spec'] = $userInformation->spec;
    $_SESSION['firstname'] = $userInformation->firstName;
    $_SESSION['lastname'] = $userInformation->lastName;
    $_SESSION['personNr'] = $userInformation->personNr;
    $_SESSION['id'] = $userInformation->doctorId;
    $_SESSION['isAdmin'] = intval($userInformation->isAdmin);
    $_SESSION['loggedin'] = true;
    $_SESSION['loginatempt'] = true;
    var_dump("Logged In");
    header("location: /home/");
}else{
    $_SESSION['loginatempt'] = true;
    header("Location: /login/");
}
