<?php

/**
 * @param string $personNr
 * @return string
 * modifierar person nummer till att byta ut de fyra sista mot XXXX
 */
function modPersonNr(string $personNr){
    $modNr = "";
    $charArray = str_split($personNr);

    for ($i = 0; $i < count($charArray); $i++) {
        if($i < 8){
            $modNr .= $charArray[$i];
        }elseif($i === 8){
            $modNr .= "-";
            $modNr .= "XXXX";
            break;
        }
    }
    return $modNr;
}


/**
 * @param string $personNr
 * @return string
 */
function modPersonNrDash(string $personNr){
    $modNr = "";
    $charArray = str_split($personNr);
    for($i = 0; $i < count($charArray); $i++){
        if($i !== 8){
            $modNr .= $charArray[$i];
        }else{
            $modNr .= "-";
            $modNr .= $charArray[$i];
        }
    }
    return $modNr;
}

/**
 * @param null
 * @return object
 * initierar databasen enklare i alla filer
 */
function initDb(){
    $filename = "C:/code/GA/database/database.db";
    $dns = "sqlite:$filename";
    $pdo = new PDO($dns);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->exec('PRAGMA foreign_keys = ON');
    return $pdo;
}

function requireLogin(){
    if(isset($_SESSION['loggedin'])){
        if($_SESSION['loggedin'] == true){
        }
        else{
            header("Location: /login");
        }
    }
}

function redirectURL ($path){
    header("Location: $path");
}