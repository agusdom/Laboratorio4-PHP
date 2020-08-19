<?php 
namespace Model;

//use Model\BeerType as BeerType;

class Beer
{
    private $id;
    private $name;
    private $density;
    private $price;
    private $origin;
    private $beerTypeId;

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

    public function getDensity()
    {
        return $this->density;
    }

    public function setDensity($density)
    {
        $this->density= $density;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price= $price;
    }

    public function getOrigin()
    {
        return $this->origin;
    }

    public function setOrigin($origin)
    {
        $this->origin= $origin;
    }

    public function getBeerTypeId()
    {
        return $this->beerTypeId;
    }

    public function setBeerTypeId($beerTypeId)
    {
        $this->beerTypeId= $beerTypeId;
    }




}

?>