<?php

function selectAccount(string $username): array
{
    $data = json_decode(file_get_contents("accounts.json"), true);
    $accounts = $data["accounts"];
    var_dump($accounts);
    $selectedAccount = [];
    $index = 0;
    foreach($accounts as $account){
        if($account["username"] == $username){
            $selectedAccount = $account;
            break;
        }
        $index++;
    }
    if($selectedAccount != []){
        return $selectAccount;
    }else{
        return ["no-account" => "no account found"];
    }

}



function generateToken(string $username): void
{
    $token = bin2hex(random_bytes(24));
    $data = json_decode(file_get_contents("accounts.json"), true);
    var_dump($data);
}

//selectAccount("antnor211");
generateToken("antnor211");
