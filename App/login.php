<?php
$data = [];

if(!isset($_SESSION["loggedin"])){
    $_SESSION["loggedin"] = false;
}
if(!isset($_SESSION['loginatempt'])){
    $_SESSION['loginatempt'] = false;
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
rendering('views', 'login.twig', $data);