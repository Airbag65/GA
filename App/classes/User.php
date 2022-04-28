<?php
class User
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $personNr;
    public string $email;
    public string $username;
    public string $spec;
    public string $password;
    public int $isAdmin;
    public bool $loggedIn;

    public function __construct(
        $id,
        $firstName,
        $lastName,
        $personNr,
        $email,
        $username,
        $spec,
        $password,
        $isAdmin
    )
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
        $this->loggedIn = false;
    }

    /**
     * Set login state to true if not true.
     * Do nothing otherwise.
     */
    public function login()
    {
        if (!$this->loggedIn)
        {
            $this->loggedIn = true;
        }
    }

    /**
     * Set login state to false if true.
     * Do nothing otherwise.
     */
    public function logout()
    {
        if ($this->loggedIn)
        {
            $this->loggedIn = false;
        }
    }

    /**
     * @param string $username
     * @param string $newPassword
     * Byter lösenord för valt konto
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