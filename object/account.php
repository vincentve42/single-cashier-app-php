<?php

class Account{
    protected string $password;
    public string $username;
    public int $isAdmin;
    public string $created_at;
    public string $updated_at;

    public function __construct(string $username, string $password, int $isAdmin)
    {
        $this->username = $username;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }
    public function __destruct()
    {
        
    }
    public function save($database)
    {
    
    }

}
?>
