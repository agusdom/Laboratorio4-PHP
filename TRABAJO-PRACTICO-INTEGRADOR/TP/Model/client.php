<?php
namespace Model;

class Client
{
    private $dni;
     private $name;
     private $lastName;
  
     
     public function getDni()
     {
         return $this->dni;
     }

     public function setDni($dni)
     {
         $this->id= $dni;
     }

     public function getName()
     {
         return $this->name;
     }

     public function setName($name)
     {
         $this->name= $name;
     }

     public function getLastName()
     {
         return $this->lastName;
     }

     public function setLastName($lastName)
     {
         $this->lastName= $lastName;
     }
}

?>