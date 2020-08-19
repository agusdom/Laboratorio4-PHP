<?php 
namespace Model;

use Model\Rol as Rol;

class User
{
    private $id;
    private $name;
    private $lastName;
    private $email;
    private $password;
    private $rol;

    public function getId()
     {
         return $this->id;
     }

     public function setId($id)
     {
         $this->id= $id;
     }

     

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name=$name;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname=$lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email=$email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password=$password;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol(Rol $rol)
    {
        $this->rol=$rol;
    }
}

?>