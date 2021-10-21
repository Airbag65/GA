<?php
require_once "functions.php";

class Account
{
    public string $account;
    public array $selectedAccount; 

    public function __construct(
        string $account,)
    {
        $this->account = $account;
        $this->selectedAccount = selectAccount($this->account);
    }


    public function login()
    {
        $firstName = $this->selectedAccount["first_name"];
        if($this->selectedAccount["token"] == ""){
            generateToken($this->account);
            $this->selectedAccount = selectAccount($this->account);
        }
    }
}