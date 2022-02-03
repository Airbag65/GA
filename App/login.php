<?php
var_dump($_SESSION);
$data = [
"userField" => "Användarnamn eller mejl",
"passwordField" => "Lösenord"
];

if(!isset($_SESSION["loggedin"])){
    $_SESSION["loggedin"] = false;
    echo "loggedin false<br>";
}
if(!isset($_SESSION['loginatempt'])){
    $_SESSION['loginatempt'] = false;
    echo "loginatempt false<br>";
}

if(isset($_SESSION['loggedin'])){
    if(isset($_SESSION['loginatempt'])){
        if ($_SESSION['loginatempt']){
            if (!$_SESSION['loggedin']) {
                $data['loginfail'] = "Fel användarnamn eller lösenord";
            }else{
                $data['loginfail'] = "";
            }
        }
    }
}
rendering('views', 'index.twig', $data);