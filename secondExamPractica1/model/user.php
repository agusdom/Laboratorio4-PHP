<?php
namespace Model;

class User
{
    private $userId;
    private $email;
    private $password;

    public function setUserId($userId)
    {
        $this->userId= $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setEmail($email)
    {
        $this->email= $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password= $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    
}
?>