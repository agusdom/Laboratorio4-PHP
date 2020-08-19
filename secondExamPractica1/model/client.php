<?php
namespace Model;
use Model\Category as Category;
use Model\Photo as Photo;

class Client
{
    private $clientId;
    private $lastName;
    private $firstName;
    private $dni;
    private $email;
    private $address;
    private $category;
    private $picture;


    public function setClientId($clientId)
    {
        $this->clientId= $clientId;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setLastName($lastName)
    {
        $this->lastName= $lastName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName= $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setDni($dni)
    {
        $this->dni= $dni;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setEmail($email)
    {
        $this->email= $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setaddress($address)
    {
        $this->address= $address;
    }

    public function getaddress()
    {
        return $this->address;
    }

    public function setcategory(Category $category)
    {
        $this->category= $category;
    }

    public function getcategory()
    {
        return $this->category;
    }

    public function setPicture(Photo $picture)
    {
        $this->picture= $picture;
    }

    public function getPicture()
    {
        return $this->picture;
    }



}
?>