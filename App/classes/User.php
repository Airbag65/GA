<?php
class User
{
    public $id;
    public $firstName;
    public $lastName;
    public $personNr;
    public $email;
    public $username;
    public $spec;
    public $password;
    public $isAdmin;

    public function __construct($id, $firstName, $lastName, $personNr, $email, $username, $spec, $password, $isAdmin)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->personNr = $personNr;
        $this->email = $email;
        $this->username = $username;
        $this->spec = $spec;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }

    /**
     * @param string $username
     * @param string $newPassword
     * Byter lösenord för vald profil
     * Ingen return
     */
    public function updatePassword(string $username,string $newPassword)
    {
        $password = md5($newPassword);
        $pdo = initDb();
        $sql = <<<EOD
        update doctors 
            set password = ?
        where nameAbbrev is ?;
        EOD;
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $password]);
    }
}