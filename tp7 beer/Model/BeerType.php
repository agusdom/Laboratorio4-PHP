<?php
namespace Model;

class BeerType
{
    private $id;
    private $name;
    private $description;
    private $recipe;
    
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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description= $description;
    }

    public function getRecipe()
    {
        return $this->recipe;
    }

    public function setRecipe($recipe)
    {
        $this->recipe= $recipe;
    }
}


?>