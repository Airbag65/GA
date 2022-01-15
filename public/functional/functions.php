<?php

/**
 * @param string $personNr
 * @return string
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