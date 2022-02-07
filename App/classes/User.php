<?php
class User
{
    public $id;
    public $firstName;
    public $lastName;
    public $age;
    public $personNr;
    public $email;
    public $username;
    public $spec;
    public $password;
    public $isAdmin;

    public function __construct($id, $firstName, $lastName, $age, $personNr, $email, $username, $spec, $password, $isAdmin)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->personNr = $personNr;
        $this->email = $email;
        $this->username = $username;
        $this->spec = $spec;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }


}