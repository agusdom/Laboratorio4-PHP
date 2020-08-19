<?php
namespace Model;

use Model\Photo as Photo;

class Artist
{
    private $id;
     private $name;
     private $lastName;
     private $ArtisticName;
     private $photo;
     
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

     public function getArtisticName()
     {
         return $this->artisticName;
     }

     public function setArtisticName($artisticName)
     {
         $this->artisticName= $artisticName;
     }

     public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto(Photo $photo)
    {
        $this->photo= $photo;
    }

}

?>