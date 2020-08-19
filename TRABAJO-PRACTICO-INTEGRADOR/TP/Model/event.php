<?php 
namespace Model;

use Model\Category as Category;
use Model\Photo as Photo;

class Event
{
    private $id;
    private $name;
    private $category;
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

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category= $category;
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