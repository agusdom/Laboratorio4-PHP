<?php
namespace Model;

class Category
{
    private $categoryId;
    private $description;
    private $isActive;

    public function setCategoryId($categoryId)
    {
        $this->categoryId= $categoryId;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function setDescription($description)
    {
        $this->description= $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setIsActive($isActive)
    {
        $this->isActive= $isActive;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    

    
    
}
?>